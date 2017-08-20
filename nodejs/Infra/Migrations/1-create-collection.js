const { messages } = require('./Seed/messages_sample')

module.exports.id = 'create-collection'

module.exports.up = function (done) {
  this.db.createCollection('messages', {}, function (_, collection) {
    collection.insertMany(messages, function (_, response) {
      done()
    })
  })
}
