const { messages } = require("./Seed/messages_sample")

module.exports.id = "create-collection"

module.exports.up = function (done) {
  this.db.createCollection('messages', {}, function(error, collection) {
    collection.insertMany(messages, function(error, response){
      done()
    })
  })
}
