const faker = require('faker')
const { Factory } = require('rosie')

const MessageFixture = new Factory()
  .attr('uid', () => faker.random.uuid())
  .attr('sender', () => faker.name.findName())
  .attr('subject', () => faker.random.word())
  .attr('message', () => faker.lorem.sentence())
  .attr('time_sent', () => faker.date.recent())
  .attr('isRead', () => faker.random.boolean())
  .attr('isArchived', () => faker.random.boolean())

MessageFixture.notRead = new Factory()
  .extend(MessageFixture)
  .attr('isRead', () => false)

MessageFixture.notArchived = new Factory()
  .extend(MessageFixture)
  .attr('isArchived', () => false)


module.exports = MessageFixture
