"use stict";

const MessageModel = require('./models/messages.model');
const UsersModel = require('./models/users.model');
const cookieParser = require('cookie-parser');
const passport = require('passport');
const config = require('./config');

function auth (socket, next) {

    // Parse cookie
    cookieParser()(socket.request, socket.request.res, () => {});

    // JWT authenticate
    passport.authenticate('jwt', {session: false}, function (error, decryptToken, jwtError) {
        if(!error && !jwtError && decryptToken) {
            next(false, {username: decryptToken.username, id: decryptToken.id});
        } else {
            next('guest');
        }
    })(socket.request, socket.request.res);

}

module.exports = io => {
    io.on('connection', function (socket) {
        auth(socket, (guest, user) => {
            if(!guest) {
                socket.join(user.username);
                socket.username = user.username;
                socket.emit('connected', `you are connected to chat as ${user.username}`);

            }
        });




        socket.on('msg', content => {
            const obj = {
                date: new Date(),
                topic: content.topic,
                content: content.content,
                receiver: content.receiver,
                username: socket.username

            };

            MessageModel.create(obj, err => {
                if(err) {return console.error("MessageModel", err);
            } else if (content.receiver == 'toAll') {
                socket.broadcast.emit("message", obj);
            } else {
                socket.broadcast.to(content.receiver).emit('message', obj);
            }


            });
        });

    
        socket.on('receiveUsers', () => {
            UsersModel
                .find({})

                .sort({username: 1})
                .lean()
                .exec((err, users) => {
                    if(!err) {
                        socket.emit("users", users);
                    }
                })
        });


        socket.on('receiveHistory', () => {
            MessageModel
                .find({$or: [{'receiver': socket.username}, {'receiver': 'toAll'}]})
                .find({})
                .sort({date: -1})
                .limit(5)
                .sort({date: 1})
                .lean()
                .exec( (err, messages) => {
                    if(!err) {
                        socket.emit("history", messages);
                    }

                })

        })
    });
};
