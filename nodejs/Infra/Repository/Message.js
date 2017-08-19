module.exports = (mongodb) => {
  const collection = mongodb && mongodb.collection('messages') || {}

  const MessageRepository = {
    list (page, limit) {
      return collection
        .find({})
        .skip(limit * (page - 1))
        .limit(limit)
        .toArray()
    },
    listArchived (page, limit) {
      return collection
        .find({ archived: true })
        .skip(limit * (page - 1))
        .limit(limit)
        .toArray()
    },
    findOne (uid) {
      return collection
        .findOne({ uid })
    },
    save (message) {
      return collection
        .updateOne({ uid:message.uid }, { $set:message })
        .then(_ => message)
    }
  }

  return MessageRepository
}
