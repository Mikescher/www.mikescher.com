if (!window.console) {
    window.console = {
        log: function() {}
    };
}

function inheritPrototype(childObject, parentObject) {
    var copyOfParent = Object.create(parentObject.prototype);
    copyOfParent.constructor = childObject;
    childObject.prototype = copyOfParent;
}

function matchWinnerToChar(w) {
    switch (w) {
        case MatchWinner.ABORT:
            return '#';
        case MatchWinner.PLAYER_1:
            return '1';
        case MatchWinner.DRAW:
            return 'X';
        case MatchWinner.PLAYER_2:
            return '2';
        case MatchWinner.UNDEFINIED:
            return '?';
        default:
            throw "non-enum value in MatchWinnerToChar(" + w + ")";
    }
}

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
};

Array.prototype.last = function() {
    return this[this.length - 1];
};

Array.prototype.peek = function() {
    return this[this.length - 1];
};

String.prototype.reps = function( num ) {
    return new Array( num + 1 ).join( this );
};

var RepetitionState = {
    OPEN: 10,
    CLOSED: 11,
    AWAITING_NUMBER: 12,
    FINISHED: 13,
};
var RepetitionMode = {
    UNDEFINIED: 10,
    ITERATIVE: 11,
    RECURSIVE: 12,
};
var MatchWinner = {
    UNDEFINIED: 0,
    PLAYER_1: 10,
    DRAW: 15,
    PLAYER_2: 20,
    ABORT: -1,
};

var BF_CHARS = ['+', '-', '<', '>', '[', ']', '.'];
var PP_CHARS = ['(', ')', '*', '{', '}', '%', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
var NM_CHARS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];


//######################################################

function BFPart() {}

BFPart.prototype.constructor = BFPart;
BFPart.prototype.append = function(part) {
    throw "abstract";
};
BFPart.prototype.toProgram = function() {
    throw "abstract";
};
BFPart.prototype.finish = function() {
    throw "abstract";
};

//######################################################

function BFCommand(c) {
    this.cmd = c;

    BFPart.call(this);
}

inheritPrototype(BFCommand, BFPart);

BFCommand.prototype.constructor = BFCommand;
BFCommand.prototype.append = function(part) {
    throw "Invalid Appendix";
};

BFCommand.prototype.toProgram = function() {
    return this.cmd;
};

BFCommand.prototype.finish = function() {
    // void
};

//######################################################

function BFConcat() {
    this.list = []

    BFPart.call(this);
}

inheritPrototype(BFConcat, BFPart);

BFConcat.prototype.constructor = BFConcat;

BFConcat.prototype.append = function(part) {
    if (this.list.length > 0)
        this.list.last().finish();

    this.list.push(part);
};

BFConcat.prototype.toProgram = function() {
    return this.list.map(function(x) {
        return x.toProgram();
    }).join("");
};

BFConcat.prototype.finish = function() {
    if (this.list.length > 0)
        this.list.last().finish();
};

BFConcat.prototype.splitAroundCenter = function() {
    var left = new BFConcat();
    var center = null;
    var right = new BFConcat();

    var i = 0;
    for (; i < this.list.length; i++) {
        if (this.list[i] instanceof BFCenterLiteral) {
            center = this.list[i];
            break;
        } else {
            left.append(this.list[i]);
        }
    }

    i++;

    for (; i < this.list.length; i++) {
        if (this.list[i] instanceof BFCenterLiteral) {
            throw "Two much {} in Repetition found";
        } else {
            right.append(this.list[i]);
        }
    }

    if (center === null)
        throw "No {} in Repetition found";

    return [left, center, right];
};

//######################################################

function BFCenterLiteral() {
    BFConcat.call(this);
}

inheritPrototype(BFCenterLiteral, BFConcat);

BFCenterLiteral.prototype.constructor = BFCenterLiteral;

//######################################################

function BFRepetition() {
    this.state = RepetitionState.OPEN;
    this.mode = RepetitionMode.UNDEFINIED;
    this.parts = new BFConcat();
    this.count = 0;

    BFPart.call(this);
}

inheritPrototype(BFRepetition, BFPart);

BFRepetition.prototype.constructor = BFCommand;
BFRepetition.prototype.append = function(part) {
    this.parts.append(part);
};

BFRepetition.prototype.toProgram = function() {
    if (this.mode == RepetitionMode.ITERATIVE) {
        return new Array(this.count + 1).join(this.parts.toProgram());
    } else if (this.mode == RepetitionMode.RECURSIVE) {
        var split = this.parts.splitAroundCenter();

        var left = new Array(this.count + 1).join(split[0].toProgram());
        var center = split[1].toProgram();
        var right = new Array(this.count + 1).join(split[2].toProgram());

        return left + center + right;
    } else {
        throw "RepMode not definied";
    }
};

BFRepetition.prototype.close = function() {
    if (this.state == RepetitionState.CLOSED) return;

    if (this.state != RepetitionState.OPEN)
        throw ("state != OPEN, state == " + this.state);

    this.state = RepetitionState.CLOSED;
};

BFRepetition.prototype.startNumberWaiting = function(md) {
    this.mode = md;

    if (this.state == RepetitionState.AWAITING_NUMBER) return;

    if (this.state != RepetitionState.CLOSED)
        throw ("state != CLOSED, state == " + this.state);

    this.state = RepetitionState.AWAITING_NUMBER;
};

BFRepetition.prototype.finish = function() {
    if (this.state == RepetitionState.FINISHED) return;

    if (this.state != RepetitionState.AWAITING_NUMBER)
        throw ("state != AWAITING_NUMBER, state == " + this.state);

    this.state = RepetitionState.FINISHED;
};

BFRepetition.prototype.addNumber = function(p) {
    this.count *= 10;
    this.count += p;
};

//######################################################

function BFProg (_code) {
    this.code_position = 0;
    this.board_position = 0;
    this.inverted = false;    // +  <-> -
    this.active = true;
    this.code = _code;
}

BFProg.prototype.constructor = BFProg;

BFProg.prototype.step = function(match, invertboard) {
    //console.log(this.code_position + " #> " + this.getCommand() + " (" + match.get(this.board_position, invertboard) + ")");
    switch(this.getCommand()) {
        case '+': 
            match.inc(this.board_position, invertboard);
            break;
            
        case '-': 
            match.dec(this.board_position, invertboard);
            break;
            
        case '<': 
            this.board_position--;
            break;
            
        case '>': 
            this.board_position++;
            break;
            
        case '.': 
            // Do nothing
            break; 
            
        case '[': 
            if (match.get(this.board_position, invertboard) == 0) {
                this.skip_forward();
                this.code_position--; // reverse effect of next move
            }
            break;
            
        case ']': 
            this.skip_backward();
            this.code_position--; // reverse effect of next move
            break;
            
        default: 
            throw "Unknown Char in prog: " + this.code.charAt(this.position);
    } 
    this.move();
}

BFProg.prototype.move = function() {
    if (this.code_position < this.code.length - 1)
    	this.code_position++;
    else {
        if (this.active) console.log("END OF CODE REACHED");
        this.active = false;
    }
    
}

BFProg.prototype.skip_forward = function() {
    var depth = 0;
    
    do {
        var chr = this.code.charAt(this.code_position);
        if (chr == '[')
            depth++
        else if (chr == ']')
            depth--;
        
        this.code_position++;
        
        
    } while (depth > 0)
}

BFProg.prototype.skip_backward = function() {
    var depth = -1;
    
    do {
        this.code_position--;
        
        var chr = this.code.charAt(this.code_position);
        if (chr == '[')
            depth++
        else if (chr == ']')
            depth--;
        
        
    } while (depth < 0)
}

BFProg.prototype.getCommand = function() {
    if (this.active) {
        switch(this.code.charAt(this.code_position)) {
            case '+': return this.inverted ? '-' : '+';
            case '-': return this.inverted ? '+' : '-';
            case '<': return '<';
            case '>': return '>';
            case '.': return '.';
            case '[': return '[';
            case ']': return ']';
            default: throw "Unknown Char in prog: " + this.code.charAt(this.code_position);
        } 
    } else {
        return '.';
    }
}

BFProg.prototype.isFlowCommand = function() {
    if (this.active) {
        switch(this.code.charAt(this.code_position)) {
            case '+': return false;
            case '-': return false;
            case '<': return true;
            case '>': return true;
            case '.': return false;
            case '[': return true;
            case ']': return true;
            default: throw "Unknown Char in prog: " + this.code.charAt(this.code_position);
        } 
    } else {
        return '.';
    }
}

BFProg.prototype.getBoardPos = function(invertboard, size) {
    if (invertboard)
        return (size - 1) - this.board_position;
    else
        return this.board_position;
}

BFProg.prototype.isOOB = function(size) {
    return this.board_position < 0 || this.board_position >= size;
}

//######################################################

function BFMatch (_size, _prog1, _prog2) {
    this.size = _size;
    this.prog1 = _prog1;
    this.prog2 = _prog2;
    
    this.flagZeroed1 = 0;
    this.flagZeroed2 = 0;
    this.roundCount = 0;
    this.winner = MatchWinner.UNDEFINIED;
        this._intervalID = -1
        
    this.map = new Array(_size);
    for(var i = 0; i < _size; i++) this.map[i] = 0;
    this.map[0] = 128;
    this.map[this.map.length - 1] = 128;
}

BFMatch.prototype.constructor = BFMatch;

BFMatch.prototype.calc = function() {
    for(;;) {
        this.roundCount++;

        if (this.prog2.isFlowCommand()) { // Flow-cmd first -> reverse order
            this.prog2.step(this, true);
            this.prog1.step(this, false);
        } else {
            this.prog1.step(this, false);
            this.prog2.step(this, true);
        }

        this.stepFlag();
        this.stepWinner();
        
        if (this.winner != MatchWinner.UNDEFINIED)
            break;
    }
    
    return this.winner;
}

BFMatch.prototype.start = function(canvas, width, height, speed) {
    this.param_canvas = canvas;
    this.param_width  = width;
    this.param_height = height;
    
    this._intervalID = setInterval(this.tick.bind(this), speed);
};

BFMatch.prototype.stop = function(winner) {
    if (winner == MatchWinner.UNDEFINIED)
        throw new "can't stop on undef";
    
    if (this._intervalID != -1) {
   		clearInterval(this._intervalID);
        this._intervalID = -1
    }

    console.log("Match stopped winner: " + winner);
    
    switch (winner) {
        case MatchWinner.PLAYER_1:
            this.winner = MatchWinner.PLAYER_1;
            break;
        case MatchWinner.DRAW:
            this.winner = MatchWinner.DRAW;
            break;
        case MatchWinner.PLAYER_2:
            this.winner = MatchWinner.PLAYER_2;
            break;
        case MatchWinner.ABORT:
            this.winner = MatchWinner.ABORT;
            break;
        default:
        	throw new "no-enum value in stop()";
    }
};
    
BFMatch.prototype.tick = function() {
    this.step();
    this.draw(this.param_canvas, this.param_width, this.param_height);
};

BFMatch.prototype.step = function() {
    this.roundCount++;

    if (this.prog2.isFlowCommand()) { // Flow-cmd first -> reverse order
        this.prog2.step(this, true);
        this.prog1.step(this, false);
    } else {
        this.prog1.step(this, false);
        this.prog2.step(this, true);
    }

	this.stepFlag();
    this.stepWinner();

    if (this.winner == MatchWinner.PLAYER_1)
         alert('Player 1 (left) won');
   	else if (this.winner == MatchWinner.PLAYER_2)
         alert('Player 2 (right) won');
   	else if (this.winner == MatchWinner.DRAW)
         alert('Draw');
};
    
BFMatch.prototype.stepFlag = function() {
    if (this.map[0] == 0)
        this.flagZeroed1++;
    else
        this.flagZeroed1 = 0;
    
    if (this.map[this.size - 1] == 0)
        this.flagZeroed2++;
    else
        this.flagZeroed2 = 0;
}

BFMatch.prototype.getFlagWeight = function(fg) {
    if (fg == MatchWinner.PLAYER_1) {
        return Math.abs(this.map[0]);
    } else if (fg == MatchWinner.PLAYER_2) {
        return Math.abs(this.map[this.size - 1]);
    } else {
        throw "Unknown player: " + fg;
    }
}

BFMatch.prototype.stepWinner = function() {
    if (this.roundCount > 100000 && this.getFlagWeight(MatchWinner.PLAYER_1) == this.getFlagWeight(MatchWinner.PLAYER_2))
        this.stop(MatchWinner.DRAW);
    
    if ((this.prog1.isOOB(this.size) || this.flagZeroed1 >= 2) && (this.prog2.isOOB(this.size) || this.flagZeroed2 >= 2))
        this.stop(MatchWinner.DRAW);
        
    if (this.prog1.isOOB(this.size) || this.flagZeroed1 >= 2)
        this.stop(MatchWinner.PLAYER_2);
        
    if (this.prog2.isOOB(this.size) || this.flagZeroed2 >= 2)
        this.stop(MatchWinner.PLAYER_1);
    
    if (this.roundCount > 100000 && this.getFlagWeight(MatchWinner.PLAYER_1) > this.getFlagWeight(MatchWinner.PLAYER_2))
        this.stop(MatchWinner.PLAYER_1);
    
        if (this.roundCount > 100000 && this.getFlagWeight(MatchWinner.PLAYER_1) < this.getFlagWeight(MatchWinner.PLAYER_2))
        this.stop(MatchWinner.PLAYER_2);
}
    
BFMatch.prototype.inc = function(idx, invertboard) {
    if (invertboard) idx = (this.size - 1) - idx;
    
    this.map[idx]++;    
    this.map[idx] = (this.map[idx] + 127 + 256) % 256 - 127;
}

BFMatch.prototype.dec = function(idx, invertboard) {
    if (invertboard) idx = (this.size - 1) - idx;
    
    this.map[idx]--;    
    this.map[idx] = (this.map[idx] + 127 + 256) % 256 - 127;
}

BFMatch.prototype.get = function(idx, invertboard) {
    if (invertboard) idx = (this.size - 1) - idx;
    
    return this.map[idx];
}

BFMatch.prototype.draw = function(canvas, width, height) {
    var BORDER = 4;
    var PADDING = 2;
    
    var cell_width  = (((width - 2*BORDER) + PADDING) / this.size) - PADDING;
    var cell_height = cell_width * 3/4;
    var max_height  = (height - 2*BORDER - cell_height) / 2;
   
    cell_width  = Math.floor(cell_width);
    cell_height = Math.floor(cell_height);
    max_height  = Math.floor(max_height);
    
    canvas.lineWidth = 1;
    
    
    canvas.fillStyle="#FFFFFF";
    canvas.fillRect(0, 0, width, height);
    canvas.fillStyle="#000000";
    
    for (var i = 0; i < this.size; i++) {
        var cell_value = this.map[i];
        
        var x = Math.floor(BORDER + i*(cell_width + PADDING)) + 0.5;
        var y = Math.floor(height/2 - cell_height/2) + 0.5;
        
        canvas.fillStyle="#F3F3F3";
        canvas.beginPath();
        canvas.rect(x, y, cell_width, cell_height);
        canvas.closePath();
        canvas.fill();
        canvas.stroke();

         if (this.prog1.getBoardPos(false, this.size) == i) {
             canvas.fillStyle="#F00";
             canvas.beginPath();
             canvas.moveTo(x, y);
             canvas.lineTo(x + cell_height/2, y + cell_height/2);
             canvas.lineTo(x, y + cell_height);
             canvas.lineTo(x, y);
             canvas.closePath();
             canvas.fill();
             canvas.stroke();
         }

         if (this.prog2.getBoardPos(true, this.size) == i) {
             canvas.fillStyle="#00F";
             canvas.beginPath();
             canvas.moveTo(x + cell_width, y);
             canvas.lineTo(x + cell_width - cell_height/2, y + cell_height/2);
             canvas.lineTo(x + cell_width, y + cell_height);
             canvas.lineTo(x + cell_width, y);
             canvas.closePath();
             canvas.fill();
             canvas.stroke();
         }
            
        if (i == 0)
    		canvas.fillStyle="#F00";
        else if (i == this.size - 1)
    		canvas.fillStyle="#00F";
        else
    		canvas.fillStyle="#484D51";
        if (cell_value < 0) {
            canvas.beginPath();
            canvas.rect(x, 
                        y + cell_height,
                        cell_width, 
                        -Math.floor(max_height * cell_value/128));
            canvas.closePath();
            canvas.fill();
            canvas.stroke();
        } else if (cell_value > 0) {
            canvas.beginPath();
            canvas.rect(x, 
                        y, 
                        cell_width, 
                        -Math.ceil(max_height * cell_value/128));
            canvas.closePath();
            canvas.fill();
            canvas.stroke();
        }
    }
}

//######################################################
//######################################################
//######################################################

function expand(input) {
    var root = new BFConcat();
    var stack = [];
    stack.push(root);
    var linep = 1;
    var charp = 1;

    for (var i = 0; i < input.length; i++) {
        var c = input.charAt(i);
        var next = ((i + 1) == input.length) ? (' ') : (input.charAt(i + 1));

        if (c == '\n') {
            linep++;
            charp = 0;
        }
        charp++;

        if (BF_CHARS.contains(c)) {
            stack.peek().append(new BFCommand(c));
        } else if (c == '(') {
            var rep = new BFRepetition();
            stack.peek().append(rep);
            stack.push(rep);
        } else if (c == ')' && stack.peek() instanceof BFRepetition && stack.peek().state == RepetitionState.OPEN) {
            stack.peek().close();
            
            if (next != '*' && next != '%') {
                stack.peek().startNumberWaiting(RepetitionMode.ITERATIVE);
                stack.peek().addNumber(1);
                stack.peek().finish();
                stack.pop();
            }
        } else if (c == '{' && stack.peek() instanceof BFRepetition) {
            var rep = new BFCenterLiteral();
            stack.peek().append(rep);
            stack.push(rep);
        } else if (c == '}' && stack.peek() instanceof BFCenterLiteral) {
            stack.pop();
        } else if (c == '*' && stack.peek() instanceof BFRepetition) {
            var rep = stack.peek();

            rep.startNumberWaiting(RepetitionMode.ITERATIVE);
        } else if (c == '%' && stack.peek() instanceof BFRepetition) {
            var rep = stack.peek();

            rep.startNumberWaiting(RepetitionMode.RECURSIVE);
        } else if (NM_CHARS.contains(c) && stack.peek() instanceof BFRepetition && stack.peek().state == RepetitionState.AWAITING_NUMBER) {
            var rep = stack.peek();

            rep.addNumber(c - '0');

            if (!NM_CHARS.contains(next))
                stack.pop();
        } else {
            console.log("Ignore Char: '" + c + "'");
        }
    }


    if (stack.peek() !== root)
        throw ("Stack not unwinded" + stack);

    return root.toProgram();
}

//######################################################

function getCollapseCount(code, width) {
    var count = 0;
    var piece = code.substr(0, width);
    
    for(var pos = 0; pos <= code.length; pos += width) {
        if (code.substr(pos, width) == piece)
            count++;
        else
            return count;
    }
    
    return count;
}
    
function isSquareBracketHill(code) {
    var height = 0;
    
    for(var p = 0; p < code.length; p++) {
        if (code.charAt(p) == '[') height++;
        else if (code.charAt(p) == ']') height--;
        
        if (height < 0) return false;
    }
    
    return height == 0;
}
    
function collapse(code) {
    if (code.length == 0) return code;
    
    var maxImprovement = 0;
    var maxImpWidth = -1;
    var maxImpRep = -1;
    
    for(var i = 1; i < (code.length/2 + 1); i++) {
        var width = i;
        
        if (! isSquareBracketHill(code.substr(0, width))) continue;
        
        var rep = getCollapseCount(code, width);
        
        if (width * rep > width + 4 && (width * rep - (width + 4)) > maxImprovement) {
            maxImprovement = (width * rep - (width + 4));
            maxImpWidth = width;
            maxImpRep = rep
        }
    }
    
    if (maxImpWidth > 0)
        return "(" + collapse(code.substr(0, maxImpWidth)) + ")*" + maxImpRep + collapse(code.substr(maxImpRep * maxImpWidth, code.length));
    else
        return code.substr(0, 1) + collapse(code.substr(1, code.length));
}
    
//######################################################

document.getElementById("a_expand").onclick = onExpandClicked;
document.getElementById("a_collapse").onclick = onCollapseClicked;
document.getElementById("a_run").onclick = onRunClicked;
document.getElementById("a_stop").onclick = onStopClicked;
document.getElementById("a_arena").onclick = onArenaClicked;

function onExpandClicked() {
    var source1 = document.getElementById("source_1");
    var sink1 = document.getElementById("sink_1");
    var source2 = document.getElementById("source_2");
    var sink2 = document.getElementById("sink_2");

    sink1.value = expand(source1.value);
    sink2.value = expand(source2.value);

    return false;
}
    
function onCollapseClicked() {
    {
        var source = document.getElementById("source_1");
        var sink = document.getElementById("sink_1");
        sink.value = collapse(expand(source.value));
    }
     
    {
        var source = document.getElementById("source_2");
        var sink = document.getElementById("sink_2");
        sink.value = collapse(expand(source.value));
    }
        
    return false;
}

var match = null;
    
function onRunClicked() {
    
    if (match != null) {
        match.stop(MatchWinner.ABORT);
    	match = null;
    }
    
    var param_size = parseInt( document.getElementById("run_size").value );
    var param_speed = parseInt( document.getElementById("run_speed").value );
    var source1 = document.getElementById("source_1");
    var code1 = expand(source1.value);
    var source2 = document.getElementById("source_2");
    var code2 = expand(source2.value);
    var brd = document.getElementById("board");
    var ctx = brd.getContext("2d"); 
    
    brd.setAttribute('width', brd.offsetWidth);
    brd.setAttribute('height', brd.offsetHeight);

    match = new BFMatch(param_size, new BFProg(code1), new BFProg(code2));
    
    document.getElementById("sink_1").value = code1;
    document.getElementById("sink_2").value = code2;
    
    match.start(ctx, brd.width, brd.height, param_speed);
    
    return false;
}
    
function onStopClicked() {
    
    if (match == null) return false;
    
    document.getElementById("sink_1").value = '';
    document.getElementById("sink_2").value = '';
    
    var canvas = document.getElementById("board").getContext("2d");
    canvas.fillStyle="#FFFFFF";
    canvas.fillRect(0, 0, document.getElementById("board").width, document.getElementById("board").height)
    
    match.stop(MatchWinner.ABORT);
    match = null;
    
    return false;
}
    
function onArenaClicked() {
    
    if (match != null) {
        match.stop(MatchWinner.ABORT);
    	match = null;
    }
    
    var source1 = document.getElementById("source_1");
    var code1 = expand(source1.value);
    var source2 = document.getElementById("source_2");
    var code2 = expand(source2.value);
    
    var result = new Array(31);
    for (var i = 0; i < 31; i++) result[i] = new Array(2);
    var result_p1 = 0;
    var result_draw = 0;
    var result_p2 = 0;
    
    for (var msize = 10; msize <= 30 ; msize++) {
        var p1 = new BFProg(code1);
        var p2 = new BFProg(code2);
        
        match = new BFMatch(msize, p1, p2);
        
        result[msize][0] = match.calc();
        
        if (result[msize][0] == MatchWinner.PLAYER_1) result_p1++;
        if (result[msize][0] == MatchWinner.DRAW) result_draw++;
        if (result[msize][0] == MatchWinner.PLAYER_2) result_p2++;
        
        //-----------------------------------------

        var p1 = new BFProg(code1);
        var p2 = new BFProg(code2);
        p2.inverted = true;
        
        var match = new BFMatch(msize, p1, p2);
        
        result[msize][1] = match.calc();
        
        if (result[msize][1] == MatchWinner.PLAYER_1) result_p1++;
        if (result[msize][1] == MatchWinner.DRAW) result_draw++;
        if (result[msize][1] == MatchWinner.PLAYER_2) result_p2++;
    }
    
    var log = "";
    
    log += "Wins Player 1 (left) :" + result_p1 + '\n';
    log += "Draws                :" + result_draw + '\n';
    log += "Wins Player 2 (left) :" + result_p2 + '\n';
    log += "" + '\n';
    
    log += " ".reps(9) + "|";
    for (var i = 10; i <= 30; i++) log += ' ' + i;
    log += '\n';
    
    log += "-".reps(9) + "|" + "-".reps(3 * 21) + '\n';
    
    log += "Normal   | ";
    for (var i = 10; i <= 30; i++) log += matchWinnerToChar(result[i][0]) + "  ";
    log += "\n";
    
    log += "Inverted | ";
    for (var i = 10; i <= 30; i++) log += matchWinnerToChar(result[i][1]) + "  ";
    log += "\n";    
    
    document.getElementById("log").value = log;
    
    return false;
}