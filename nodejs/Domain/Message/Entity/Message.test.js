const { expect } = require('chai')

const MessageEntity = require('Domain/Message/Entity/Message')

const MessageEntityFixture = require('Features/Fixtures/Message.fixture')

describe('Message Entity', () => {
  describe('#SCHEMA', () => {
    const rawArguments = MessageEntityFixture.build()
    const messageEntity = new MessageEntity(rawArguments)

    it('has an uid', () => expect(messageEntity.uid).to.equal(rawArguments.uid))
    it('has a sender', () => expect(messageEntity.sender).to.equal(rawArguments.sender))
    it('has a subject', () => expect(messageEntity.subject).to.equal(rawArguments.subject))
    it('has a message', () => expect(messageEntity.message).to.equal(rawArguments.message))
    it('has a time_sent', () => expect(messageEntity.time_sent).to.equal(rawArguments.time_sent))
  })

  describe('#read', () => {
    it('read a Message', () => {
      const rawArguments = MessageEntityFixture.notRead.build()
      const messageEntity = new MessageEntity(rawArguments)

      messageEntity.read()

      expect(messageEntity.isRead).to.be.true
    })
  })

  describe('#archive', () => {
    it('archive a Message', () => {
      const rawArguments = MessageEntityFixture.notArchived.build()
      const messageEntity = new MessageEntity(rawArguments)

      messageEntity.archive()

      expect(messageEntity.isArchived).to.be.true
    })
  })
})
