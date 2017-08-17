const { defineSupportCode } = require('cucumber')
const { expect } = require('chai')

const MessageFixture = require("Fixtures/Message.fixture")
const MessageAgregate = require("Domain/Message/Aggregate")
const MessageRepository = require("Infra/Repository/Message")

defineSupportCode(({ Given, When, Then }) => {
  Given(/^I have Messages$/, function () {
    const MessageRepositoryStub = this.World.stubDependency(MessageRepository)

    this.World.Messages = MessageFixture.buildList()
    MessageRepositoryStub.resolves(this.World.Messages)

    this.World.Expects = { MessageRepositoryStub }
  })
  When('I Retrieve a paginateable list of Messages', function (callback) {
    this.World.Result = MessageAgregate.list()
  })
  Then('I receive a paginateable list of Messages', function (callback) {
    const { Result, Expects: { MessageRepositoryStub } } = this.World

    expect(MessageRepositoryStub.calledOnce).to.be.equal(true)
    expect(Result).to.be.deep.equal(this.World.Messages)
  })
})
