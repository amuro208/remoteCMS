angular.module('app')
.directive('xlPercentage', function($filter) {
  // A directive for both formatting and properly validating a percentage value.
  // Assumes that our internal model is expressed as floats -1 to +1: .099 is 9.9%
  // Formats display into percents 1-100, and parses user inputs down to the model.
  // Parses user input as floats between 0 and 100 into floats less than 1.
  // Validates user input to be within the range -100 to +100.
  // Sets Angular $valid property accordingly on the ngModelController.
  // If a `pct-max` or `pct-min` attribute is specified on the <input>, will use those bounds instead.
  // If a `pct-decimals` attr present, will truncate inputs accordingly.

  function outputFormatter(modelValue, decimals) {
    var length = decimals || 2;
    if (modelValue != null) {
      return $filter('number')(parseFloat(modelValue) * 100, length);
    } else {
      return undefined;
    }
  };

  function inputParser(viewValue, decimals) {
    var length = decimals || 4;
    if (viewValue != null) {
      return $filter('number')(parseFloat(viewValue) / 100, length);
    } else {
      return undefined;
    }

  }

  function isWithinBounds(value, upper, lower) {
    if (value >= lower && value <= upper) {
      return true;
    } else {
      return false;
    }
  }

  return {
    restrict: 'A',
    require: 'ngModel',
    link: function postLink(scope, element, attrs, ctrl) {
      ctrl.$parsers.unshift(function(viewValue) {
        // confirm the input from the view contains numbers, before parsing
        var numericStatus = viewValue.match(/(\d+)/),
        min = parseFloat(attrs.pctMin) || -100,
        max = parseFloat(attrs.pctMax) || 100,
        decimals = parseFloat(attrs.pctDecimals) || 4,
        bounded = isWithinBounds(viewValue, max, min);
        if (numericStatus !== null && bounded) {
          ctrl.$setValidity('percentage', true);
          // round to max four digits after decimal
          return inputParser(viewValue, decimals);
        } else {
          ctrl.$setValidity('percentage', false);
          return undefined
        }
      });

      ctrl.$formatters.unshift(outputFormatter);
      // we have to watch for changes, and run the formatter again afterwards
      element.on('change', function(e) {
        var element = e.target;
        element.value = outputFormatter(ctrl.$modelValue, 2);
      });

      element.on('focus', function(e) {
        var element = e.target;
        element.value = outputFormatter(ctrl.$modelValue, 2);
      });
    }
  };
});
