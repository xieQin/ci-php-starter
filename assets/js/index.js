$(function() {
  FastClick.attach(document.body);

  var actionList = {
    //demo
    'test': function(self) {
      testFunc(self)
    }
  }
  var $body = $(document)

  $body.on('click', '[data-action]', function () {
    var actionName = $(this).data('action')
    var action = actionList[actionName]
    var self = this
    if ($.isFunction(action)) action(self)
  })

  /**
   * [testFunc 测试方法]
   * @param  {[type]} self [description]
   * @return {[type]}      [description]
   */
  function testFunc (self) {
    console.log(self)
  }
})