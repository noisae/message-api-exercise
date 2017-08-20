const express = require('express')
const bodyParser = require('body-parser')
const { MongoClient } = require('mongodb')
const router = require('Application/router')
const { API_PORT } = require('Application/config')

const { MONGO_HOST, MONGO_PORT, MONGO_DB } = require('Application/config')
const MessageRepository = require('Infra/Repository/Message')

MongoClient.connect(`mongodb://${MONGO_HOST}:${MONGO_PORT}/${MONGO_DB}`, (error, db) => {
  if (error) {
    throw error
  }

  // Init Repositories
  MessageRepository(db)

  // Init Server
  const api = express()
  api.use(bodyParser.json())
  api.use(router)

  api.listen(API_PORT, () => console.log(`Message Api is running on port ${API_PORT}`))
})
