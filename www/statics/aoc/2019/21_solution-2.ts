namespace AdventOfCode2019_21_2
{
	const DAY     = 21;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const code = input.trim().split(",").map(p => parseInt(p.trim()));

		let springcode = 
		[
			"NOT A T",  // T = !A
			"NOT B J",  // J = !B
			"OR T J",   // J = !A or !B
			"NOT C T",  // T = !B
			"OR T J",   // J = !A or !B or !C
			"NOT D T",  // T = !D
			"NOT T T",  // T = D
			"AND T J",  // J = (!A or !B or !C) and D

			"NOT E T",  // T = !E
			"NOT T T",  // T = E
			"OR H T",   // T = H or E
			"AND T J",  // J = (!A or !B or !C) and D and (H or E)

			"RUN"
		];

		let rnr = new Interpreter(code, springcode.map(p => p+"\n").join("").split("").map(p => p.charCodeAt(0)));

		let output = springcode.join("\n")+"\n\n";
		AdventOfCode.outputConsole(output);
		while (!rnr.is_halted)
		{
			rnr.singleStep();

			if (rnr.output.length>0)
			{
				let v = rnr.output[0];
				output += String.fromCharCode(v);
				rnr.output = [];

				if (v > 255)
				{
					AdventOfCode.output(DAY, PROBLEM, v.toString());
					return;
				}
			}

		}
		await AdventOfCode.outputIntermed(output); // droid fell in hole

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
