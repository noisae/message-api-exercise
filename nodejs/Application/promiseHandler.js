const PromiseHandler = (callback) => (request, response) =>
  callback(request)
    .then(result => response.send(JSON.stringify(result)))
    .catch(error => response.status(400).send(JSON.stringify({ error })))

module.exports = PromiseHandler
