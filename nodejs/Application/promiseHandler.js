const successResult = (response, result) => {
  response.status(200)
  response.json(result)
}

const errorResult = (response, error) => {
  response.status(400)
  response.json({ error })
}

const PromiseHandler = (callback) => (request, response) =>
  callback(request)
    .then(result => successResult(response, result))
    .catch(error => errorResult(response, error))

module.exports = PromiseHandler
