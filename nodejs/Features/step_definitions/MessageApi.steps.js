const { defineSupportCode } = require('cucumber')
const { expect } = require('chai')

const MessageFixture = require("Fixtures/Message.fixture")
const MessageEntity = require("Domain/Message/Entity/Message")
const MessageApiService = require("Domain/Message/ApiService")
const MessageRepository = require("Infra/Repository/Message")()

defineSupportCode(({ Given, When, Then }) => {
  Given(/^I have (.*)\s?Messages$/, function (archived) {
    const MessageRepositoryMock = this.World.mockDependency(MessageRepository)

    this.World.Constants.Messages = MessageFixture.buildList(1)
    this.World.Constants.page = 2
    this.World.Constants.limit = 1

    let method = 'list'
    if (archived) {
      method = 'listArchived'
    }

    MessageRepositoryMock
      .expects(method)
      .withArgs(this.World.Constants.page, this.World.Constants.limit)
      .resolves(this.World.Constants.Messages)

    this.World.Expects = { MessageRepositoryMock }
    this.World.Boundaries = { MessageRepository }
  })

  When(/^I Retrieve a paginateable list of (.*)\s?Messages$/, async function (archived) {
    const page = this.World.Constants.page
    const limit = this.World.Constants.limit
    if(archived) {
      this.World.Result = await MessageApiService.listArchived({ page, limit }, this.World.Boundaries)
    } else {
      this.World.Result = await MessageApiService.list({ page, limit }, this.World.Boundaries)
    }
  })

  Then(/^I receive a paginateable list of (.*)\s?Messages$/, function (archived) {
    const { Result, Expects: { MessageRepositoryMock } } = this.World

    const expectResult = this.World.Constants.Messages

    expect(MessageRepositoryMock.verify()).to.be.equal(true)
    expect(Result).to.be.deep.equal(expectResult)
  })

  Given(/^I have a Message$/, function () {
    const MessageRepositoryMock = this.World.mockDependency(MessageRepository)

    this.World.Constants.Message = MessageFixture.build()

    MessageRepositoryMock
      .expects('findOne')
      .withArgs(this.World.Constants.Message.uid)
      .resolves(this.World.Constants.Message)

    this.World.Expects = { MessageRepositoryMock }
    this.World.Boundaries = { MessageRepository }
  })

  When(/^I Retrieve a Message$/, async function () {
    this.World.Result = await MessageApiService.show(this.World.Constants.Message.uid, this.World.Boundaries)
  })

  Then(/^I receive a Message$/, function () {
    const { Result, Expects: { MessageRepositoryMock } } = this.World

    const expectResult = this.World.Constants.Message

    expect(MessageRepositoryMock.verify()).to.be.equal(true)
    expect(Result).to.be.deep.equal(expectResult)
  })

  Given(/^I have a Message to (Read|Archive)$/, function (actionType) {
    const MessageRepositoryMock = this.World.mockDependency(MessageRepository)

    this.World.Constants.Message = MessageFixture.notRead.build()
    let MessageRepositorySaveArgs = Object.assign({}, this.World.Constants.Message, { isRead: true })
    if(actionType === 'Archive') {
      this.World.Constants.Message = MessageFixture.notArchived.build()
      MessageRepositorySaveArgs = Object.assign({}, this.World.Constants.Message, { isArchived: true })
    }

    MessageRepositoryMock
      .expects('findOne')
      .withArgs(this.World.Constants.Message.uid)
      .resolves(this.World.Constants.Message)

    MessageRepositoryMock
      .expects('save')
      .withArgs(new MessageEntity(MessageRepositorySaveArgs))
      .resolves(this.World.Constants.Message)

    this.World.Expects = { MessageRepositoryMock }
    this.World.Boundaries = { MessageRepository }
  })

  When(/^I Read a Message$/, async function () {
    this.World.Result = await MessageApiService.read(this.World.Constants.Message.uid, this.World.Boundaries)
  })

  When(/^I Archive a Message$/, async function () {
    this.World.Result = await MessageApiService.archive(this.World.Constants.Message.uid, this.World.Boundaries)
  })

  Then(/^The Message was saved as (Read|Archived)$/, function (actionType) {
    const { Result, Expects: { MessageRepositoryMock } } = this.World

    const expectResult = this.World.Constants.Message

    expect(MessageRepositoryMock.verify()).to.be.equal(true)
    expect(Result).to.be.deep.equal(expectResult)
  })
})
