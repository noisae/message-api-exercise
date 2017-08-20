const dependencies = {
  MessageRepository: require('Infra/Repository/Message')(),
  MessageEntity: require('Domain/Message/Entity/Message')
}

const ApiService = {
  list ({ page = 1, limit = 10 }, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.list(page, limit)
  },
  listArchived ({ page = 1, limit = 10 }, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.listArchived(page, limit)
  },
  show (uid, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.findOne(uid)
  },
  async read (uid, injection) {
    const { MessageRepository, MessageEntity } = Object.assign({}, dependencies, injection)
    const message = await MessageRepository.findOne(uid)
    const messageEntity = new MessageEntity(message)

    messageEntity.read()

    return MessageRepository.save(messageEntity)
  },
  async archive (uid, injection) {
    const { MessageRepository, MessageEntity } = Object.assign({}, dependencies, injection)
    const message = await MessageRepository.findOne(uid)
    const messageEntity = new MessageEntity(message)

    messageEntity.archive()

    return MessageRepository.save(messageEntity)
  }
}

module.exports = ApiService
