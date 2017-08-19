const dependencies = {
  MessageRepository: require('Infra/Repository/Message')
}

const AccountsClient = {
  list ({ page = 1, limit = 10}, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.list(page, limit)
  },
  listArchived ({ page = 1, limit = 10}, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.listArchived(page, limit)
  },
  show (uid, injection) {
    const { MessageRepository } = Object.assign({}, dependencies, injection)
    return MessageRepository.findOne(uid)
  }
}

module.exports = AccountsClient
