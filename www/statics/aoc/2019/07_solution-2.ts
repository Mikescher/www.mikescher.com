namespace AdventOfCode2019_07_2
{
	const DAY     = 7;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		let code = input.split(",").map(p => parseInt(p.trim()));

		let outputs: number[] = [];

		for(let i=0; i < 5*5*5*5*5; i++)
		{
			let v = i;
			let a1 = v%5 + 5; v = Math.floor(v/5);
			let a2 = v%5 + 5; v = Math.floor(v/5);
			let a3 = v%5 + 5; v = Math.floor(v/5);
			let a4 = v%5 + 5; v = Math.floor(v/5);
			let a5 = v%5 + 5; v = Math.floor(v/5);

			if ([a1,a2,a3,a4,a5].sort((a, b) => a - b).filter((v,i,s) => s.indexOf(v)===i).length !== 5) continue;

			const r = evalConfiguration(code, a1,a2,a3,a4,a5)
			
			outputs.push(r);
			console.log([a1,a2,a3,a4,a5].toString() + "  -->  " + r);
		}

		const max = outputs.sort((a, b) => a - b).reverse()[0];

		AdventOfCode.output(DAY, PROBLEM, max.toString());
	}

	function evalConfiguration(code: number[], a1 : number, a2 : number, a3 : number, a4 : number, a5 : number) : number
	{
		const runner1 = new Interpreter(code, [a1, 0]);
		const runner2 = new Interpreter(code, [a2]);
		const runner3 = new Interpreter(code, [a3]);
		const runner4 = new Interpreter(code, [a4]);
		const runner5 = new Interpreter(code, [a5]);

		let optr1 = 0;
		let optr2 = 0;
		let optr3 = 0;
		let optr4 = 0;
		let optr5 = 0;

		while (!runner5.is_halted)
		{
			runner1.singleStep();
			if (runner1.output.length > optr1)
			{
				runner2.inputqueue.push(runner1.output[optr1]); 
				optr1++; 
			}

			runner2.singleStep();
			if (runner2.output.length > optr2)
			{ 
				runner3.inputqueue.push(runner2.output[optr2]); 
				optr2++; 
			}

			runner3.singleStep();
			if (runner3.output.length > optr3)
			{ 
				runner4.inputqueue.push(runner3.output[optr3]); 
				optr3++; 
			}

			runner4.singleStep();
			if (runner4.output.length > optr4)
			{ 
				runner5.inputqueue.push(runner4.output[optr4]); 
				optr4++; 
			}

			runner5.singleStep();
			if (runner5.output.length > optr5)
			{
				runner1.inputqueue.push(runner5.output[optr5]);
				optr5++;
			}
		}

		return runner5.output.reverse()[0];
	}

	class Interpreter
	{
		program: number[];
		inputqueue: number[];
		instructionpointer: number;
		output: number[];

		is_halted: boolean = false;

		constructor(prog: number[], input: number[])
		{
			this.program = Object.assign([], prog);
			this.inputqueue = Object.assign([], input);
			this.instructionpointer = 0;
			this.output = [];
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

		singleStep() : StepResult
		{
			const cmd = new Op(this.program[this.instructionpointer]);

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
		HALT = 99,
	}

	enum ParamMode
	{
		POSITION_MODE  = 0,
		IMMEDIATE_MODE = 1,
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
			else throw "Unknown opcode: "+this.opcode;
		}

		getParameter(proc: Interpreter, index: number): number
		{
			const prog = proc.program;
			const ip   = proc.instructionpointer;

			let p = prog[ip+1+index];

				 if (this.modes[index] == ParamMode.POSITION_MODE)  p = prog[p];
			else if (this.modes[index] == ParamMode.IMMEDIATE_MODE) p = p;
			else throw "Unknown ParamMode: "+this.modes[index];

			return p;
		}

		setParameter(proc: Interpreter, index: number, value: number): void
		{
			const prog = proc.program;
			const ip   = proc.instructionpointer;

			let p = prog[ip+1+index];

				 if (this.modes[index] == ParamMode.POSITION_MODE)  prog[p] = value;
			else if (this.modes[index] == ParamMode.IMMEDIATE_MODE) throw "Immediate mode not allowed in write";
			else throw "Unknown ParamMpde: "+this.modes[index];
		}
	}
}
