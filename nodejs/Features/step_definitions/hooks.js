const { defineSupportCode } = require('cucumber')
const sinon = require('sinon')

defineSupportCode(({ Before, After }) => {
  Before(function () {
    this.World = {
      mocks: [],
      stubs: [],
      mockDependency: (instance) => {
        const mock = sinon.mock(instance)
        this.World.mocks.push(mock)
        return mock
      },
      stubDependency: (instance, functionName) => {
        const stub = sinon.stub(instance, functionName)
        this.World.stubs.push(stub)
        return stub
      },
      Boundaries: {},
      Constants: {}
    }
  })

  After(function () {
    this.World.mocks.forEach(mock => mock.restore())
    this.World.stubs.forEach(stub => stub.restore())
  })
})
