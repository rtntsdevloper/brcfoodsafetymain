function onProgClick (event) {
  const $el = $(event.currentTarget)
  $el.parent().attr('data-progress', $el.index())
}

function initProgress () {
  $('.progress')
    .attr('data-progress', 2)
    .on('click', 'li', onProgClick)
}

$(() => setTimeout(initProgress, 1000))