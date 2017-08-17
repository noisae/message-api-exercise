const faker = require('faker')
const { Factory } = require('rosie')

const MessageFixture = new Factory()
  .attr('uid', () => faker.random.uuid())
  .attr('sender', () => faker.name.findName())
  .attr('subject', () => faker.random.word())
  .attr('message', () => faker.lorem.sentence())
  .attr('time_sent', () => faker.date.recent())
  .attr('read', () => faker.random.boolean())
  .attr('achived', () => faker.random.boolean())

MessageFixture.read = new Factory()
  .extend(MessageFixture)
  .attr('read', () => faker.random.boolean())

MessageFixture.archive = new Factory()
  .extend(MessageFixture)
  .attr('achived', () => faker.random.boolean())


module.exports = MessageFixture
