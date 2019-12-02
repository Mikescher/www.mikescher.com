namespace AdventOfCode2019_02_2
{
	const DAY     = 2;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);

		let mem = input.split(",").map(p => parseInt(p));

		for(let noun=0; noun<=99;noun++)
		for(let verb=0; verb<=99;verb++)
		{
			if (exec(noun, verb, Object.assign([], mem)) == 19690720)
			{
				AdventOfCode.output(DAY, PROBLEM, (100*noun+verb).toString());
				return;
			}
		}

		AdventOfCode.output(DAY, PROBLEM, "error");
	}

	function exec(noun: number, verb: number, memory: number[])
	{
		let automata = memory;

		automata[1] = noun;
		automata[2] = verb;

		for(let i=0; i < automata.length; i+=4)
		{
			const op   = automata[i+0];
			const arg1 = automata[automata[i+1]];
			const arg2 = automata[automata[i+2]];
			const dest = automata[i+3];
			
			if (op==1) automata[dest] = arg1 + arg2;
			else if (op==2) automata[dest] = arg1 * arg2;
			else break;
		}

		return automata[0];
	}
}
