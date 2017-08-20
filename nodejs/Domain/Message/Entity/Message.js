const { Entity, validatorAdapter } = require('speck-entity')
const Joi = require('joi')
const adapter = validatorAdapter('joi', require('joi'))

class Message extends Entity {
  read () {
    this.isRead = true
  }

  archive () {
    this.isArchived = true
  }
}

Message.SCHEMA = {
  uid: adapter(Joi.number()),
  sender: adapter(Joi.string()),
  subject: adapter(Joi.string()),
  message: adapter(Joi.string()),
  time_sent: {
    validator: adapter(Joi.object().type(Date)),
    type: Date,
    builder: (value) => {
      if (typeof value === 'number') {
        return new Date(value)
      }

      return value
    }
  },
  isRead: adapter(Joi.boolean()),
  isArchived: adapter(Joi.boolean())
}

module.exports = Message
