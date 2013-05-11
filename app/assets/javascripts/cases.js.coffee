# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/

$(document).ready ->
  $('#timer').click ->
    $("div#timecount").countdown
      since: new Date()
      format: "YOWDHMS"
      description: "Hello"
    if $('#timer').hasClass('started')
      $("#timecount").countdown('pause')
      $("#timer").removeClass("started")
      $("#timer").html("Start Timer")
    else
      $('#timecount').countdown('resume')
      $('#timer').addClass('started')
      $('#timer').html("Stop Timer")
      time = $('#timecount').countdown('getTimes')



