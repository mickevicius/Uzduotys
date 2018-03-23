function response (data) {
    let resp = data.responseText;
    try {
        if (data.message != void (0)) {
            resp = data.message;
        } else {
            resp = JSON.parse(data.responseText);
            resp = resp.message;
        }
    } catch (e) {}
    return resp;
}

$(".logout-btn").on('click', e => {
    e.preventDefault();
    $.ajax({
        url: '/logout',
        type: 'POST',
        data: {},
        success: (res) => {
            alert(response(res));
            location.reload();
        },
        error: (res) => {
            alert(response(res));
        }
    });
});

$( document ).ready( () => {
    var socket = io.connect('http://localhost:5555');
    socket.on('connected', function (msg) {
        console.log(msg);
        socket.emit('connectedUser');
        socket.emit('receiveHistory');
        socket.emit('receiveUsers');


    });

    socket.on('message', (msg) => {
        addMessage(msg);
        setClickAction();
        console.log(msg);
    });



    socket.on('history', messages => {
        for (let message of messages) {
            addMessage(message);
        }
        setClickAction();
    });

    socket.on('users', users => {
        for (let user of users) {
            addUser(user);
        }
    });

    var selector1 = $("textarea[name='message']");
    var selector2 = $("select[name='topic']");
    var selector3 = $("select[name='receiver']");




    $('.chat-message button.send').on('click', e => {
        e.preventDefault();


        var messageContent = {topic: selector2.val(), content: selector1.val().trim(), receiver: selector3.val().trim()};

        if(messageContent !== '') {
            socket.emit('msg', messageContent);
            selector1.val('');
        }
    });


    $('.reset').on('click', (e) => {
        e.preventDefault();
        selector1.val('');
        selector2.val('task');
        selector3.val('toAll');


    });

function setClickAction() {
    $('.delete').on('click', (e) => {

        e.preventDefault();

        var x = e.target.id;
        var h = "." + x;
        console.log("paspausta" + x );

        $(h).hide();
});


}


    function encodeHTML (str){
        return $('<div />').text(str).html();
    }


    function addUser(user) {
        user.username = encodeHTML(user.username);

        var selectOptions = `<option name="users" value="${user.username}">${user.username}</option>`;

        $(selectOptions).appendTo('.allUsers');
    }





    function addMessage(message) {



        message.date      = (new Date(message.date)).toLocaleString();
        message.topic     = encodeHTML(message.topic);
        message.id       = encodeHTML(message._id);
        message.receiver  = encodeHTML(message.receiver);
        message.username  = encodeHTML(message.username);
        message.content   = encodeHTML(message.content);




        var html = `
            <li class="${message.id}">
                <div class="message-data">
                    <span class="message-data-name">${message.username}</span>
                    <span class="message-data-time">${message.date}</span>
                </div>
                <div class="message my-message ${message.topic}" dir="auto">
                    <p class="message-content">${message.content}</p>
                    <input type="submit" id="${message.id}" class="delete" value="delete">
                </div>
            </li>`;






        $(html).hide().appendTo('.chat-history ul').slideDown(200);

        $(".chat-history").animate({ scrollTop: $('.chat-history')[0].scrollHeight}, 1000);


    }
});
