
const BefState = Object.freeze ({ UNINIITIALIZED: {}, INITIAL: {}, RUNNING: {}, PAUSED: {} });
const BefSpeed = Object.freeze ({ NORMAL: {str:'+'}, FAST: {str:'++'}, SUPERFAST: {str:'3+'}, MAX: {str:'4+'} });

Array.prototype.peek = function() { return this[this.length - 1]; };
Array.prototype.revjoin = function(sep) {
    let str='';
    for(let i=this.length-1; i >= 0;i--) {if (i<this.length-1)str+=sep;str+=this[i]}
    return str;
};

function BefObject(domBase) {
    this.btnStart     = domBase.getElementsByClassName('b93rnr_start')[0];
    this.btnStop      = domBase.getElementsByClassName('b93rnr_pause')[0];
    this.btnReset     = domBase.getElementsByClassName('b93rnr_reset')[0];
    this.btnSpeed     = domBase.getElementsByClassName('b93rnr_speed')[0];
    this.pnlCode      = domBase.getElementsByClassName('b93rnr_data')[0];
    this.pnlBottom    = domBase.getElementsByClassName('b93rnr_outpanel')[0];
    this.pnlOutput    = domBase.getElementsByClassName('b93rnr_output')[0];
    this.pnlStack     = domBase.getElementsByClassName('b93rnr_stack')[0];
    this.lblStackSize = domBase.getElementsByClassName('b93rnr_stacksize')[0];

    this.state    = BefState.UNINIITIALIZED;
    this.initial  = atob(this.pnlCode.getAttribute('data-befcode'));
    this.code     = [];
    this.width    = 0;
    this.height   = 0;
    this.position = [0, 0];
    this.delta    = [0, 0];
    this.strmode  = false;
    this.output   = '';
    this.stack    = [];
    this.timer    = null;
    this.psteps   = 0;
    this.simspeed = BefSpeed.SUPERFAST;
}

BefObject.prototype.Init = function() {
    this.state = BefState.INITIAL;

    let parse = this.parseBef(this.initial);

    this.code     = parse[0];
    this.width    = parse[1];
    this.height   = parse[2];
    this.position = [0, 0];
    this.delta    = [1, 0];
    this.strmode  = false;
    this.output   = '';
    this.stack    = [];
    this.psteps   = 0;
};

BefObject.prototype.start = function() {
    if (this.state === BefState.UNINIITIALIZED) this.Init();

    if (this.delta[0]===0 && this.delta[1]===0) {
        this.updateUI();
        this.updateDisplay();
        return;
    }

    this.state = BefState.RUNNING;

    this.updateUI();
    this.updateDisplay();

    this.setTimer();
};

BefObject.prototype.setTimer = function() {
    let me = this;
    this.timer = setTimeout(function() { me.step(); if (me.state!==BefState.RUNNING)return; me.setTimer(); }, 0);
};

BefObject.prototype.stop = function() {
    this.state = BefState.PAUSED;
    clearTimeout(this.timer);
    // pause

    this.updateUI();
    this.updateDisplay();
};

BefObject.prototype.reset = function() {
    if (this.state === BefState.RUNNING) this.stop();

    this.state = BefState.INITIAL;
    this.Init();
    this.state = BefState.INITIAL;

    this.updateUI();
    this.updateDisplay();
};

BefObject.prototype.incSpeed = function() {

         if (this.simspeed === BefSpeed.NORMAL)    this.simspeed = BefSpeed.FAST;
    else if (this.simspeed === BefSpeed.FAST)      this.simspeed = BefSpeed.SUPERFAST;
    else if (this.simspeed === BefSpeed.SUPERFAST) this.simspeed = BefSpeed.MAX;
    else if (this.simspeed === BefSpeed.MAX)       this.simspeed = BefSpeed.NORMAL;

    this.updateUI();
};

BefObject.prototype.step = function() {

    if (this.simspeed === BefSpeed.NORMAL) {

        this.stepSingle();

    } else if (this.simspeed === BefSpeed.FAST) {

        let t0 = performance.now();
        let stepc = 0;
        while(this.state=== BefState.RUNNING && (stepc===0 || (performance.now() - t0 < 16)) && stepc < 128) // 16ms == 60FPS
        {
            this.stepSingle();
            stepc++;
        }

    } else if (this.simspeed === BefSpeed.SUPERFAST) {

        let t0 = performance.now();
        let first = true;
        while(this.state=== BefState.RUNNING && (first || (performance.now() - t0 < 16))) // 16ms == 60FPS
        {
            this.stepSingle();
            first = false;
        }

    } else if (this.simspeed === BefSpeed.MAX) {

        let t0 = performance.now();
        let first = true;
        while(this.state=== BefState.RUNNING && (first || (performance.now() - t0 < 33))) // 32ms == 30FPS
        {
            this.stepSingle();
            first = false;
        }
    }

    if (this.state !== BefState.RUNNING) this.updateUI();
    this.updateDisplay();
};

BefObject.prototype.stepSingle = function() {
    let chr = this.code[this.position[1]][this.position[0]];
    this.exec(chr);
    this.move();

    if (this.delta[0]===0 && this.delta[1]===0) {
        console.log('Finished in ' + this.psteps + ' steps');
        this.stop();
    }
};

BefObject.prototype.exec = function(chr) {
    if (this.strmode)
    {
        this.psteps++;

        if (chr === '"') this.strmode = false;
        else this.push_c(chr);
    }
    else
    {
        let t1=0;
        let t2=0;
        let t3=0;

        if (chr !== ' ') this.psteps++;

        switch (chr)
        {
            case ' ':  /* NOP */ break;
            case '+':  this.push_i(this.pop_i()+this.pop_i()); break;
            case '-':  t1 = this.pop_i(); this.push_i(this.pop_i()-t1); break;
            case '*':  this.push_i(this.pop_i()*this.pop_i()); break;
            case '/':  t1 = this.pop_i(); t2 = this.pop_i(); this.push_i(  (t1 === 0) ? (0) : Math.floor(t2/t1)  ); break;
            case '%':  t1 = this.pop_i(); t2 = this.pop_i(); this.push_i(  (t1 === 0) ? (0) : (t2%t1)  ); break;
            case '!':  this.push_b(!this.pop_b()); break;
            case '`':  t1 = this.pop_i(); t2 = this.pop_i(); this.push_b(t2 > t1); break;
            case '>':  this.delta = [+1,0]; break;
            case '<':  this.delta = [-1,0]; break;
            case '^':  this.delta = [0,-1]; break;
            case 'v':  this.delta = [0,+1]; break;
            case '?':  this.delta = [[+1,0],[-1,0],[0,+1],[0,-1]][Math.floor(Math.random()*4)]; break;
            case '_':  this.delta = [[-1,0],[+1,0]][ this.pop_b()?0:1 ]; break;
            case '|':  this.delta = [[0,-1],[0,+1]][ this.pop_b()?0:1 ]; break;
            case '"':  this.strmode = true; break;
            case ':':  this.push_i(this.peek_i()); break;
            case '\\': t1 = this.pop_i(); t2 = this.pop_i(); this.push_i(t1); this.push_i(t2); break;
            case '$':  this.pop_i(); break;
            case '.':  this.output += this.pop_i() + ' '; break;
            case ',':  this.output += String.fromCharCode(this.pop_i()); break;
            case '#':  this.move(); break;
            case 'p':  t1 = this.pop_i(); t2 = this.pop_i(); t3 = this.pop_i(); this.gridset_i(t2, t1, t3); break;
            case 'g':  t1 = this.pop_i(); t2 = this.pop_i(); this.push_i(this.gridget_i(t2, t1)); break;
            case '&':  t1 = null; while (t1===null||t1===''||isNaN(parseInt(t1[0], 10))){t1=prompt("Input number",null);} this.push_i(parseInt(t1[0], 10)); break;
            case '~':  t1 = null; while (t1===null||t1===''){t1=prompt("Input character",null);} this.push_c(t1[0]); break;
            case '@':  this.delta = [0,0]; break;
            case '0':  this.push_i(0); break;
            case '1':  this.push_i(1); break;
            case '2':  this.push_i(2); break;
            case '3':  this.push_i(3); break;
            case '4':  this.push_i(4); break;
            case '5':  this.push_i(5); break;
            case '6':  this.push_i(6); break;
            case '7':  this.push_i(7); break;
            case '8':  this.push_i(8); break;
            case '9':  this.push_i(9); break;
            default:   window.log('BefRunner: Undefinied command: ' + chr.charCodeAt(0));
        }
    }
};

BefObject.prototype.move = function() {

    this.position[0] += this.delta[0];
    this.position[1] += this.delta[1];

    if (this.position[0] < 0) this.position[0] += this.width;
    if (this.position[1] < 0) this.position[1] += this.height;

    if (this.position[0] >= this.width)  this.position[0] -= this.width;
    if (this.position[1] >= this.height) this.position[1] -= this.height;
};

BefObject.prototype.push_i    = function(v)     { this.stack.push(v); };
BefObject.prototype.pop_i     = function()      { return this.stack.pop(); };
BefObject.prototype.peek_i    = function()      { return this.stack.peek(); };
BefObject.prototype.push_b    = function(v)     { this.stack.push(v?1:0); };
BefObject.prototype.pop_b     = function()      { return this.stack.pop()!==0; };
BefObject.prototype.push_c    = function(v)     { this.stack.push(v.charCodeAt(0)); };
BefObject.prototype.gridset_i = function(x,y,c) { if (x < 0 || y < 0 || x >= this.width || y >= this.height) return; this.code[y][x]=String.fromCharCode(c); };
BefObject.prototype.gridget_i = function(x,y)   { if (x < 0 || y < 0 || x >= this.width || y >= this.height) return 0; return this.code[y][x].charCodeAt(0); };

BefObject.prototype.updateUI = function() {

    classListSet(this.btnStart, 'ctrl_btn_disabled', this.state === BefState.RUNNING || this.state === BefState.PAUSED);
    classListSet(this.btnStop,  'ctrl_btn_disabled', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);
    classListSet(this.btnReset, 'ctrl_btn_disabled', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);

    classListSet(this.pnlBottom, 'b93rnr_outpanel_hidden', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);

    this.btnSpeed.innerHTML = this.simspeed.str;
};

BefObject.prototype.updateDisplay = function() {
    let str = '';
    for (let y=0; y < this.height; y++) {
        for (let x=0; x < this.width; x++) {
            let chr = this.code[y][x];
            let cc  = chr.charCodeAt(0);
            if (chr === '&') chr = '&amp;';
            if (chr === '<') chr = '&lt;';
            if (chr === '>') chr = '&gt;';
            if (chr === ' ') chr = '&nbsp;';
            if (cc===0) chr = '<span style="color:#888">0</span>';
            else if (cc>127 || cc<32) chr = '<span style="background:black;color:#888;">?</span>';
            if (x === this.position[0] && y === this.position[1]) chr = '<span style="background: dodgerblue">' + chr + '</span>';
            str += chr;
        }
        str += '<br/>';
    }
    this.pnlCode.innerHTML = str;

    this.pnlOutput.innerHTML = htmlescape(this.output);

    this.pnlStack.innerHTML = this.stack.revjoin("<br/>");

    this.lblStackSize.innerHTML = "(" + this.stack.length + ")";
};

BefObject.prototype.parseBef = function(str) {
    const lines = str.replace('\r\n', '\n').split('\n').map(function(str){return str.replace(/\s+$/, '')});
    let max = 0;
    for (let line of lines) max = Math.max(max, line.length);

    let result = [];

    for (let line of lines)
    {
        let row = [];
        for(let i=0; i < max; i++)
        {
            row.push((i < line.length ? (line[i]) : ' '));
        }
        result.push(row)
    }

    return [result, max, result.length];
};

function classListSet(e, cls, active) {
    if (active) {
        if (e.classList.contains(cls)) return;
        e.classList.add(cls);
    } else {
        if (!e.classList.contains(cls)) return;
        e.classList.remove(cls);
    }
}

function htmlescape(str) {
    str = str.replace(/&/g, "&amp;");
    str = str.replace(/</g, "&lt;");
    str = str.replace(/>/g, "&gt;");
    str = str.replace(/ /g, "&nbsp;");
    str = str.replace(/\n/g, "<br>");
    return str;
}

window.onload = function ()
{
    let elements = document.getElementsByClassName("b93rnr_base");

    for (let elem of elements) {

        let befungeObject = new BefObject(elem);

        befungeObject.btnStart.onclick = function () { if (befungeObject.btnStart.classList.contains('ctrl_btn_disabled')) return; befungeObject.start(); };
        befungeObject.btnStop.onclick  = function () { if (befungeObject.btnStop.classList.contains('ctrl_btn_disabled'))  return; befungeObject.stop(); };
        befungeObject.btnReset.onclick = function () { if (befungeObject.btnReset.classList.contains('ctrl_btn_disabled')) return; befungeObject.reset(); };
        befungeObject.btnSpeed.onclick = function () { if (befungeObject.btnSpeed.classList.contains('ctrl_btn_disabled')) return; befungeObject.incSpeed(); };
    }
};