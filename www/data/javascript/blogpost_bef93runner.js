
const BefState = Object.freeze ({ UNINIITIALIZED: {}, INITIAL: {}, RUNNING: {}, PAUSED: {} });

function BefObject(domBase) {
    this.btnStart  = domBase.getElementsByClassName('b93rnr_start')[0];
    this.btnStop   = domBase.getElementsByClassName('b93rnr_pause')[0];
    this.btnReset  = domBase.getElementsByClassName('b93rnr_reset')[0];
    this.pnlCode   = domBase.getElementsByClassName('b93rnr_data')[0];
    this.pnlBottom = domBase.getElementsByClassName('b93rnr_outpanel')[0];
    this.pnlOutput = domBase.getElementsByClassName('b93rnr_output')[0];
    this.pnlStack  = domBase.getElementsByClassName('b93rnr_stack')[0];

    this.state    = BefState.UNINIITIALIZED;
    this.code     = this.parseBef(atob(this.pnlCode.getAttribute('data-befcode')));
    this.position = [0, 0];
    this.output   = '';
    this.stack    = [];
}

BefObject.prototype.Init = function() {
    this.state = BefState.INITIAL;
};

BefObject.prototype.Start = function() {
    if (this.state === BefState.UNINIITIALIZED) this.Init();

    this.state = BefState.RUNNING;

    // run

    this.updateUI();
};

BefObject.prototype.Stop = function() {
    this.state = BefState.PAUSED;

    // pause

    this.updateUI();
};

BefObject.prototype.Reset = function() {
    if (this.state === BefState.RUNNING) this.Stop();

    //reset

    this.state = BefState.INITIAL;

    this.updateUI();
};

BefObject.prototype.updateUI = function() {

    classListSet(this.btnStart, 'ctrl_btn_disabled', this.state === BefState.RUNNING || this.state === BefState.PAUSED);
    classListSet(this.btnStop,  'ctrl_btn_disabled', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);
    classListSet(this.btnReset, 'ctrl_btn_disabled', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);

    classListSet(this.pnlBottom, 'b93rnr_outpanel_hidden', this.state === BefState.UNINIITIALIZED || this.state === BefState.INITIAL);
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

window.onload = function ()
{
    let elements = document.getElementsByClassName("b93rnr_base");

    for (let elem of elements) {

        let befungeObject = new BefObject(elem);

        befungeObject.btnStart.onclick = function () { if (befungeObject.btnStart.classList.contains('ctrl_btn_disabled')) return; befungeObject.Start(); };
        befungeObject.btnStop.onclick  = function () { if (befungeObject.btnStop.classList.contains('ctrl_btn_disabled'))  return; befungeObject.Stop(); };
        befungeObject.btnReset.onclick = function () { if (befungeObject.btnReset.classList.contains('ctrl_btn_disabled')) return; befungeObject.Reset(); };
    }
};