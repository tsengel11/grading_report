var form = $('#myForm'),
    checkbox = $('#changeShip'),
    chShipBlock = $('#changeShipInputs');

chShipBlock.hide();

console.log("Starting")

checkbox.on('click', function() {
    console.log('aaaa');
    console.log(checkbox);

    if($(this).is(':checked')) {
      chShipBlock.show();
      chShipBlock.find('input').attr('required', true);
    } else {
      chShipBlock.hide();
      chShipBlock.find('input').attr('required', false);
    }
})