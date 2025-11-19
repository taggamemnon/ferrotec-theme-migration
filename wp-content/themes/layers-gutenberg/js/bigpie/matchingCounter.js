/**
 * Initialize the odometer counter of the matching fund raising.
 * @param counter
 */
function initMatchingCounter(counter) {
  setTimeout(function() {
    document.getElementById('odometer').innerHTML = counter;
  }, 10);
}

setTimeout(function(){
  var firstMatchingCounterInit = sessionStorage.getItem('matchingCounterInit');

  if (firstMatchingCounterInit === null) {
    document.getElementById('odometer').innerHTML = 00000000;
    initMatchingCounter(matchingCounter);
    sessionStorage.setItem('matchingCounterInit', true);
  }
}, 10);