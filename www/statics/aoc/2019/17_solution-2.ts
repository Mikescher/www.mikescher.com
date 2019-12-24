namespace AdventOfCode2019_17_2
{
	const DAY     = 17;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const code = input.trim().split(",").map(p => parseInt(p.trim()));

		let [map, maxx, maxy] = await getMap(code);

		const fullpath = getFullPath(map, maxx, maxy);

		let proginput = await splitPath(fullpath, "y");

		code[0]=2;
		let rnr = new Interpreter(code, proginput);
		while(!rnr.is_halted && (rnr.output.length < 0 || rnr.output[0] !== "?".charCodeAt(0))) { rnr.output=[]; rnr.singleStep(); }
		while(!rnr.is_halted && (rnr.output.length < 0 || rnr.output[0] !== ".".charCodeAt(0))) { rnr.output=[]; rnr.singleStep(); }
		while(!rnr.is_halted)
		{
			rnr.singleStep();

			if (rnr.output.length === (maxx+1)*(maxy+1)+1)
			{
				let str = rnr.output.map(p => String.fromCharCode(p)).reduce((a,b)=>a+b);
				await AdventOfCode.outputIntermed(str);
				await AdventOfCode.sleepIfIntermed(10);
				rnr.output = [];

				AdventOfCode.outputConsole(str);
				AdventOfCode.outputConsole("---------------NEXT------------");
			}
		}

		AdventOfCode.outputConsole(rnr.output.map(p => String.fromCharCode(p)).reduce((a,b)=>a+b));


		AdventOfCode.output(DAY, PROBLEM, rnr.output[0].toString());
	}

	async function splitPath(fullpath: RoboCommand[], live: string): Promise<number[]>
	{
		let allsplits: { [pos:number]: [ number, RoboCommand[], number[] ][] } = {};
		for(let i=0; i<fullpath.length; i++) allsplits[i] = [];

		let splitmap: { [pos:number]: [ RoboCommand[], number[] ] } = {};

		let splitid = 10000;
		for(let splitlen = 10; splitlen>0;splitlen--)
		{
			let localfounds: Set<number> = new Set<number>();
			for (let start=0; start <= fullpath.length-splitlen; start++)
			{
				if (localfounds.has(start)) continue;

				let occurences = findInPath(fullpath, start, splitlen);
				if (occurences.length === 1) continue;

				for(const occ of occurences) localfounds.add(occ);

				let localsplit = fullpath.slice(start, start+splitlen);

				let localsplitstr = localsplit.map(p=>p.toString()).reduce((a,b)=>a+","+b);
				if  (localsplitstr.length>20) continue;

				let r: [ number, RoboCommand[], number[] ] = [ splitid++, localsplit, occurences ];

				splitmap[r[0]] = [ r[1], r[2] ];

				AdventOfCode.outputConsole(`||(${r[0]}) ${occurences.length} x [${localsplitstr}]  -->  [${occurences.map(p=>p.toString()).reduce((a,b)=>a+";"+b)}]`);
				
				for(const occ of occurences) allsplits[occ].push(r);
			}
		}

		// ------------

		let sf = new Splitfinder();
		sf.allsplits = allsplits;
		sf.fulllength = fullpath.length;

		sf.run();

		let result = "";
		let intresult = [];

		let progmap: {[_:number]: string} = {};
		let first = true;
		let rc0: RoboCommand[] = [];
		let rc1: RoboCommand[] = [];
		let rc2: RoboCommand[] = [];
		for(const comp of sf.results[0])
		{
			let id = "";
			if (comp in progmap) id = progmap[comp];
			else
			{
				if (Object.entries(progmap).length==0)      { id="A"; rc0 = splitmap[comp][0]; }
				else if (Object.entries(progmap).length==1) { id="B"; rc1 = splitmap[comp][0]; }
				else if (Object.entries(progmap).length==2) { id="C"; rc2 = splitmap[comp][0]; }
				progmap[comp] = id;
			}

			if (!first) { result += ","; intresult.push(44); }
			result += id;
			intresult.push(id.charCodeAt(0));
			first = false;
		}

		result += "\n";
		intresult.push(10);

		let str0 = rc0.map(p => p.toString()).reduce((a,b)=>a+","+b);
		result += str0+"\n";
		str0.split('').forEach(p => intresult.push(p.charCodeAt(0)));
		intresult.push(10);

		let str1 = rc1.map(p => p.toString()).reduce((a,b)=>a+","+b);
		result += str1+"\n";
		str1.split('').forEach(p => intresult.push(p.charCodeAt(0)));
		intresult.push(10);

		let str2 = rc2.map(p => p.toString()).reduce((a,b)=>a+","+b);
		result += str2+"\n";
		str2.split('').forEach(p => intresult.push(p.charCodeAt(0)));
		intresult.push(10);

		result += live + "\n";
		intresult.push(live.charCodeAt(0));
		intresult.push(10);

		AdventOfCode.outputConsole(result);

		return intresult;
	}

	class Splitfinder
	{
		allsplits: { [pos:number]: [ number, RoboCommand[], number[] ][] } = {}; // pos => [ id, path, starts ]
		fulllength: number = 0;

		results: number[][] = [];

		path: number[] = [];
		used_segments: [number, number][] = [];
		position = 0;

		run()
		{
			// abort if we finished
			if (this.position === this.fulllength) 
			{
				this.results.push(Object.assign([], this.path));
				AdventOfCode.outputConsole(">>> " + this.path.map(p => "["+p.toString()+"]").reduce((a,b)=>a+","+b) )
				return;
			}

			for(const seg of this.allsplits[this.position])
			{
				// ======== add to used_segments ========
				let added = false;
				for(let i=0; i<this.used_segments.length; i++) 
				{
					if (this.used_segments[i][0] === seg[0])
					{
						this.used_segments[i][1]++;
						added = true;
						break;
					}
				}
				if (!added)
				{
					if (this.used_segments.length === 3) continue;

					this.used_segments.push([seg[0], 1]);
				}

				// ======== add to path ========
				this.path.push(seg[0]);

				// ======== inc pos ========
				this.position += seg[1].length;

				// ======== recursion ========
				this.run();

				// ======== dec pos ========
				this.position -= seg[1].length;

				// ======== rem from path ========
				this.path.pop();

				// ======== rem from used_segments ========
				let rem_us = false;
				for(let i=0; i<this.used_segments.length; i++) 
				{
					if (this.used_segments[i][0] === seg[0])
					{
						this.used_segments[i][1]--;
						if (this.used_segments[i][1] === 0) rem_us = true;
						break;
					}
				}
				if (rem_us)
				{
					this.used_segments = this.used_segments.filter(p => p[1] > 0);
				}
			}
		}
	}

	function findInPath(fullpath: RoboCommand[], start: number, len: number): number[]
	{
		let r = [start];
		for (let s = start+len; s<=fullpath.length-len;s++)
		{
			if (isPathEqual(fullpath, start, s, len)) r.push(s);
		}
		return r;
	}

	function isPathEqual(path: RoboCommand[], start1: number, start2: number, len: number)
	{
		for (let i=0; i<len; i++)
		{
			if (!(path[start1+i].eq(path[start2+i]))) return false;
		}
		return true;
	}

	function getFullPath(map: {[_:number]: number}, maxx: number, maxy: number)
	{
		let robox = -1;
		let roboy = -1;
		let robod = Direction.North;

		for(let yy=0;yy<=maxy;yy++)
		for(let xx=0;xx<=maxx;xx++)
		{
			let id = (yy*1_0000 + xx);
			if (map[id] === 94)  { robox=xx; roboy=yy; robod=Direction.North; break; }
			if (map[id] === 62)  { robox=xx; roboy=yy; robod=Direction.East;  break; }
			if (map[id] === 60)  { robox=xx; roboy=yy; robod=Direction.West;  break; }
			if (map[id] === 118) { robox=xx; roboy=yy; robod=Direction.South; break; }
		}

		let result: RoboCommand[] = [];
		let pos: [number, number] = [robox, roboy];
		let dir = robod;

		let moves = 0;
		for(;;)
		{
			if (isScaffolding(map, moveDir(pos, dir)))
			{
				moves++;
				pos = moveDir(pos, dir);
			}
			else if (isScaffolding(map, moveDir(pos, turnLeft(dir))))
			{
				if (moves > 0) result.push(new RoboCommand(RoboCommandType.Move, moves));
				moves = 0;
				result.push(new RoboCommand(RoboCommandType.Left, 1));

				dir = turnLeft(dir);
			}
			else if (isScaffolding(map, moveDir(pos, turnRight(dir))))
			{
				if (moves > 0) result.push(new RoboCommand(RoboCommandType.Move, moves));
				moves = 0;
				result.push(new RoboCommand(RoboCommandType.Right, 1));

				dir = turnRight(dir);
			}
			else
			{
				if (moves > 0) result.push(new RoboCommand(RoboCommandType.Move, moves));

				break;
			}
		}

		AdventOfCode.outputConsole(result.map(p => p.toString()).reduce((a,b)=> a+","+b));

		return result;
	}

	function moveDir(pos: [number, number], dir: Direction): [number, number]
	{
		return move(pos, dirToVec(dir))
	}

	function move(pos: [number, number], vec: [number, number]): [number, number]
	{
		return [ pos[0]+vec[0], pos[1]+vec[1] ];
	}

	function isScaffolding(map: {[_:number]: number}, pos: [number, number])
	{
		let id = (pos[1]*1_0000 + pos[0]);
		return map[id] === 35;
	}

	class RoboCommand
	{
		cmd: RoboCommandType = RoboCommandType.Move;
		len: number = 0;

		constructor(c: RoboCommandType, l: number)
		{
			this.cmd = c;
			this.len = l;
		}

		eq(o: RoboCommand) 
		{
			if (this.cmd !== o.cmd) return false;
			if (this.len !== o.len) return false;
			return true;
		}

		toString(): string
		{
			if (this.cmd === RoboCommandType.Left) return "L";
			if (this.cmd === RoboCommandType.Right) return "R";
			if (this.cmd === RoboCommandType.Move) return ""+this.len;

			throw "??";
		}
	}

	enum RoboCommandType { Left, Right, Move }

	enum Direction
	{
		North = 1,
		South = 2,
		West  = 3,
		East  = 4,
	}

	function dirToVec(d: Direction): [number, number]
	{
		if (d === Direction.North) return [0, -1];
		if (d === Direction.East)  return [+1, 0];
		if (d === Direction.South) return [0, +1];
		if (d === Direction.West)  return [-1, 0];

		throw "-.-";
	}

	function turnRight(d: Direction): Direction
	{
		if (d === Direction.North) return Direction.East;
		if (d === Direction.East)  return Direction.South;
		if (d === Direction.South) return Direction.West;
		if (d === Direction.West)  return Direction.North;

		throw "dr";
	}

	function turnLeft(d: Direction): Direction
	{
		if (d === Direction.North) return Direction.West;
		if (d === Direction.East)  return Direction.North;
		if (d === Direction.South) return Direction.East;
		if (d === Direction.West)  return Direction.South;

		throw "dl";
	}

	async function getMap(code: number[]): Promise<[{[_:number]: number}, number, number]>
	{
		let rnr = new Interpreter(code, []);

		let map: {[_:number]: number} = {};
		let maxx = 0;
		let maxy = 0;
		let out  = "";
		let ipx=0;
		let ipy=0
		while (!rnr.is_halted)
		{
			rnr.singleStep();
			if (rnr.output.length>0) 
			{
				const v = rnr.output.pop()!;
				out += String.fromCharCode(v);
				//await AdventOfCode.outputIntermed(out);

				if (v === 10)
				{
					ipy++;
					ipx=0;
				}
				else
				{
					// AdventOfCode.outputConsole(`# [${ipx}|${ipy}] = ${v}`);

					map[ipy*1_0000 + ipx] = v;
					ipx++;

					maxx = Math.max(maxx, ipx);
					maxy = Math.max(maxy, ipy);
				}
			}
		}

		await AdventOfCode.outputIntermed(out);

		for(let yy=-1;yy<=maxy+1;yy++)
		for(let xx=-1;xx<=maxx+1;xx++)
		{
			if (!((yy*1_0000 + xx) in map)) map[yy*1_0000 + xx] = 46;
		}

		return [map, maxx, maxy];
	}

	class Interpreter
	{
		program: InfMem;
		inputqueue: number[];
		instructionpointer: number;
		output: number[];
		relative_base: number;

		is_halted: boolean = false;

		constructor(prog: number[], input: number[])
		{
			this.program = new InfMem(prog);
			this.inputqueue = input;
			this.instructionpointer = 0;
			this.output = [];
			this.relative_base = 0;
		}

		fullRun() : number[]
		{
			while(!this.is_halted)
			{
				const r = this.singleStep();

				if (r === StepResult.EXECUTED) continue;
				if (r === StepResult.HALTED) return this.output;
				if (r === StepResult.WAITING_FOR_IN) throw "not enough input";

				throw "unknown output of singleStep";
			}

			return this.output;
		}

		autoRun() : StepResult
		{
			while(!this.is_halted)
			{
				const r = this.singleStep();

				if (r === StepResult.EXECUTED) continue;
				if (r === StepResult.HALTED) return StepResult.HALTED;
				if (r === StepResult.WAITING_FOR_IN) return StepResult.WAITING_FOR_IN;

				throw "unknown output of singleStep";
			}

			return StepResult.HALTED;
		}

		singleStep() : StepResult
		{
			const cmd = new Op(this.program.r(this.instructionpointer));

			if (cmd.opcode == OpCode.ADD)
			{
				const p0 = cmd.getParameter(this, 0);
				const p1 = cmd.getParameter(this, 1);
				const pv = p0 + p1;
				cmd.setParameter(this, 2, pv);

				this.incInstrPtr(cmd);
				
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.MUL)
			{
				const p0 = cmd.getParameter(this, 0);
				const p1 = cmd.getParameter(this, 1);
				const pv = p0 * p1;
				cmd.setParameter(this, 2, pv);

				this.incInstrPtr(cmd);
				
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.HALT)
			{
				this.is_halted = true;
				return StepResult.HALTED;
			}
			else if (cmd.opcode == OpCode.IN)
			{
				if (this.inputqueue.length == 0) return StepResult.WAITING_FOR_IN;

				const pv = this.inputqueue[0];
				cmd.setParameter(this, 0, pv);
				this.inputqueue = this.inputqueue.slice(1);

				this.incInstrPtr(cmd);
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.OUT)
			{
				const p0 = cmd.getParameter(this, 0);
				this.output.push(p0);
				//AdventOfCode.outputConsole("# " + p0);

				this.incInstrPtr(cmd);

				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.TJMP)
			{
				const p0 = cmd.getParameter(this, 0);
				if (p0 != 0) this.instructionpointer = cmd.getParameter(this, 1);
				else this.incInstrPtr(cmd);
				
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.FJMP)
			{
				const p0 = cmd.getParameter(this, 0);
				if (p0 == 0) this.instructionpointer = cmd.getParameter(this, 1);
				else this.incInstrPtr(cmd);
				
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.LT)
			{
				const p0 = cmd.getParameter(this, 0);
				const p1 = cmd.getParameter(this, 1);
				const pv = p0 < p1 ? 1 : 0;
				cmd.setParameter(this, 2, pv);

				this.incInstrPtr(cmd);
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.EQ)
			{
				const p0 = cmd.getParameter(this, 0);
				const p1 = cmd.getParameter(this, 1);
				const pv = p0 == p1 ? 1 : 0;
				cmd.setParameter(this, 2, pv);

				this.incInstrPtr(cmd);
				return StepResult.EXECUTED;
			}
			else if (cmd.opcode == OpCode.ARB)
			{
				const p0 = cmd.getParameter(this, 0);
				this.relative_base = this.relative_base+p0;

				this.incInstrPtr(cmd);
				return StepResult.EXECUTED;
			}
			else throw "Unknown Op: " + cmd.opcode + " @ " + this.instructionpointer;
		}

		private incInstrPtr(cmd: Op)
		{
			this.instructionpointer += 1 + cmd.parametercount;
		}
	}

	enum StepResult { EXECUTED, HALTED, WAITING_FOR_IN }

	enum OpCode 
	{
		ADD  = 1,
		MUL  = 2,
		IN   = 3,
		OUT  = 4,
		TJMP = 5,
		FJMP = 6,
		LT   = 7,
		EQ   = 8,
		ARB  = 9,
		HALT = 99,
	}

	enum ParamMode
	{
		POSITION_MODE  = 0,
		IMMEDIATE_MODE = 1,
		RELATIVE_MODE  = 2,
	}

	class Op
	{
		opcode: OpCode;
		modes: ParamMode[];

		name: string;
		parametercount: number;

		constructor(v: number)
		{
			this.opcode = v%100;
			v = Math.floor(v/100);
			this.modes = [];
			for(let i=0; i<4; i++) 
			{
				this.modes.push(v%10);
				v = Math.floor(v/10);
			}

			     if (this.opcode == OpCode.ADD)  { this.name="ADD";   this.parametercount=3; }
			else if (this.opcode == OpCode.MUL)  { this.name="MUL";   this.parametercount=3; }
			else if (this.opcode == OpCode.HALT) { this.name="HALT";  this.parametercount=0; }
			else if (this.opcode == OpCode.IN)   { this.name="IN";    this.parametercount=1; }
			else if (this.opcode == OpCode.OUT)  { this.name="OUT";   this.parametercount=1; }
			else if (this.opcode == OpCode.TJMP) { this.name="TJMP";  this.parametercount=2; }
			else if (this.opcode == OpCode.FJMP) { this.name="FJMP";  this.parametercount=2; }
			else if (this.opcode == OpCode.LT)   { this.name="LT";    this.parametercount=3; }
			else if (this.opcode == OpCode.EQ)   { this.name="EQ";    this.parametercount=3; }
			else if (this.opcode == OpCode.ARB)  { this.name="ARB";   this.parametercount=1; }
			else throw "Unknown opcode: "+this.opcode;
		}

		getParameter(proc: Interpreter, index: number): number
		{
			const prog = proc.program;
			const ip   = proc.instructionpointer;

			let p = prog.r(ip+1+index);

				 if (this.modes[index] == ParamMode.POSITION_MODE)  p = prog.r(p);
			else if (this.modes[index] == ParamMode.IMMEDIATE_MODE) p = p;
			else if (this.modes[index] == ParamMode.RELATIVE_MODE)  p = prog.r(proc.relative_base+p);
			else throw "Unknown ParamMode: "+this.modes[index];

			return p;
		}

		setParameter(proc: Interpreter, index: number, value: number): void
		{
			const prog = proc.program;
			const ip   = proc.instructionpointer;

			let p = prog.r(ip+1+index);

				 if (this.modes[index] == ParamMode.POSITION_MODE)  prog.w(p, value);
			else if (this.modes[index] == ParamMode.IMMEDIATE_MODE) throw "Immediate mode not allowed in write";
			else if (this.modes[index] == ParamMode.RELATIVE_MODE)  prog.w(proc.relative_base+p, value);
			else throw "Unknown ParamMode: "+this.modes[index];
		}
	}

	class InfMem
	{
		private data: { [_:number]:number } = {};   

		constructor(v: number[])
		{
			for(let i=0; i<v.length;i++) this.data[i]=v[i];
		}

		r(pos: number): number
		{
			if (!(pos in this.data)) this.data[pos] = 0;
			return this.data[pos];
		}

		w(pos: number, val: number): number
		{
			return this.data[pos] = val;
		}
	}
}


