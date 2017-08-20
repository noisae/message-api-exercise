const dependencies = {
  ApiService: require('Domain/Message/ApiService')
}

const messageController = {
  list (request, injection) {
    const { ApiService } = Object.assign({}, dependencies, injection)

    const page = request.query.page > 0 && request.query.page > 0 && request.query.page || 1
    const limit = request.query.limit > 0 && request.query.limit > 0 && request.query.limit || 10

    return ApiService.list({ page, limit }, limit)
  },
  listArchived (request, injection) {
    const { ApiService } = Object.assign({}, dependencies, injection)

    const page = request.query.page > 0 && request.query.page > 0 && request.query.page || 1
    const limit = request.query.limit > 0 && request.query.limit > 0 && request.query.limit || 10

    return ApiService.listArchived({ page, limit }, limit)
  },
  show (request, injection) {
    const { ApiService } = Object.assign({}, dependencies, injection)

    const uid = request.params.uid > 0 && request.params.uid > 0 && request.params.uid || 1

    return ApiService.show(uid)
  },
  read (request, injection) {
    const { ApiService } = Object.assign({}, dependencies, injection)

    const uid = request.params.uid > 0 && request.params.uid > 0 && request.params.uid || 1

    return ApiService.read(uid)
  },
  archive (request, injection) {
    const { ApiService } = Object.assign({}, dependencies, injection)

    const uid = request.params.uid > 0 && request.params.uid > 0 && request.params.uid || 1

    return ApiService.archive(uid)
  }
}

module.exports = messageController
