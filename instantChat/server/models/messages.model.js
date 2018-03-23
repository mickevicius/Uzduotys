"use strict";

const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const MessageSchema = new Schema({
    date: {type: Date},
    topic: {type: String},
    content: {type: String},
    receiver: {type: String},
    username: {type: String}

}, {
    versionKey: false,
    collection: "MessageCollection"
});

module.exports = mongoose.model('MessageModel', MessageSchema);
