(function(){

	// event listeners
	var numbers = document.querySelectorAll('[data-selector="numbers"]'),
	    operations = document.querySelectorAll('[data-selector="operations"]'),
	    resetButton = document.querySelector('[data-selector="operations"][value="reset"]'),
	    counter;

    counter = {
    	start: '',
    	stop: ''
    };

	for (var i = numbers.length - 1; i >= 0; i--) {
	    numbers[i].addEventListener('click', function(el){
	        calculator.setOperand(el.target.value);
	    });
	}

	for (var j = operations.length - 1; j >= 0; j--) {
	    operations[j].addEventListener('click', function(el){
	        switch(el.target.value){
	            case 'result':
	                calculator.updateDisplayElement();
	                break;
	            case 'reset':
	                calculator.reset(true);
	                break;
	            default:
	                calculator.setOperationType(el.target.value);
	                break;
	        }
	    });
	}

	resetButton.addEventListener('mousedown', function(el){
		counter.start = +new Date();
	});
	resetButton.addEventListener('mouseup', function(el){
		counter.stop = +new Date();
	});


	// Calculator 'class' object
	var Calculator = function() {
	    // private properties
	    var _operationType,
	        _activeOperand,
	        _displayElement = null,
	        _allowedOperatorTypes = ['add', 'subtract', 'multiply', 'divide'];

	    var _operands = {
	        first : '',
	        second: ''
	    };

	    var _operations = {
	        add      : '+',
	        subtract : '-',
	        multiply : '*',
	        divide   : '/'
	    };

	    // 'constructor' function
	    var _init = function() {
	        _operands.first = '';
	        _operands.second = '';
	        _operationType = null;
	        _activeOperand = 'first';
	    };

	    this.reset = function(fromClick) {
	    	var fromClick = fromClick || false;
    		var operandLength = _operands[_activeOperand].length;

	    	// if pressed less than a second delete last digit, otherwise reset
	    	if( fromClick && operandLength > 0 && (counter.stop - counter.start < 1000) ){
	    		_operands[_activeOperand] = _operands[_activeOperand].substring(0, operandLength -1);
	        	this.updateDisplayElement(_operands[_activeOperand]);

	    		counter.start = '';
	    		counter.stop = '';

	    		return;
	    	}

	        _init();
	        this.updateDisplayElement(0);

	    };

	    this.getResult = function() {
	        // if the Calculator is reset by any case, return initial state, 0
	        if( this._isReset() ){
	            return 0;
	        }

	        var first = parseFloat(_operands.first);
	        var second = parseFloat(_operands.second);

	        // i'm using eval here, but consider it safe because all input from user is sanitized...
	        // alternative would be a switch case that would do a certain operation on two operands
	        var result = eval(first + _operations[_operationType] + second);

	        this._toggleActiveOperator();
	        this.reset();
	        this.updateDisplayElement(result);

	        return result;
	    };

	    this.setDisplayElement = function(el){
	        _displayElement = document.querySelector(el);
	    };

	    this.setOperand = function(value){
	    	// if 0 is the first number, don't add it to the operand e.g. 010
	    	if ( _operands[_activeOperand].length === 0 && value == '0'){
	    		return;
	    	}

	        _operands[_activeOperand] += value;
	        this.updateDisplayElement(_operands[_activeOperand]);
	    };

	    this.setOperationType = function(type){
	    	// allow for operations with negative numbers
	    	if(this._isReset() && type == _allowedOperatorTypes[1]){
	    		this.setOperand('-');
	    		return;
	    	}

	        // if not in allowed operations array, return from function
	        if( _allowedOperatorTypes.indexOf(type.toLowerCase()) === -1){
	            throw 'Operation not valid or allowed';
	        }

	        if( type ==  _operationType){
	        	return;
	        }

	        _operationType = type.toLowerCase();
	        this._toggleActiveOperator();
	    };

	    this.updateDisplayElement = function(val){
	        _displayElement.value = val || this.getResult();
	    };

	    this._toggleActiveOperator = function(){
	        _activeOperand = (_activeOperand == 'first') ? 'second' : 'first';
	    };

	    this._isReset = function(){
	    	return ( _operationType === null && _operands.first === '' && _operands.second === '' );
	    };

	    // automatically initialize the object on creation
	    _init();
	};

	// Calculator init
	var calculator = new Calculator();
	calculator.setDisplayElement('#calculator-result');

})();
