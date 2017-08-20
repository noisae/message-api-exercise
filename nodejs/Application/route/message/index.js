const { Router } = require('express')
const promiseHandler = require('Application/promiseHandler')
const MessageController = require('./Message.controller')

const messageRouter = new Router()

messageRouter.get('/', promiseHandler(MessageController.list))
messageRouter.get('/archived', promiseHandler(MessageController.listArchived))
messageRouter.get('/:uid', promiseHandler(MessageController.show))
messageRouter.post('/:uid/archive', promiseHandler(MessageController.archive))
messageRouter.post('/:uid/read', promiseHandler(MessageController.read))

module.exports = messageRouter
