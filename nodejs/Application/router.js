const { Router } = require('express')
const messageRouter = require('Application/Route/Message')

const router = new Router()
router.use('/message', messageRouter)

module.exports = router
