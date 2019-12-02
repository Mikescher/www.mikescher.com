namespace AdventOfCode2019_02_1
{
	const DAY     = 2;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);

		let automata = input.split(",").map(p => parseInt(p));

		automata[1] = 12;
		automata[2] = 2;

		for(let i=0; i < automata.length; i+=4)
		{
			const op   = automata[i+0];
			const arg1 = automata[automata[i+1]];
			const arg2 = automata[automata[i+2]];
			const dest = automata[i+3];
			console.log("["+dest+"] <- "+arg1+" {"+op+"} "+arg2)
			if (op==1) automata[dest] = arg1 + arg2;
			else if (op==2) automata[dest] = arg1 * arg2;
			else break;
		}

		AdventOfCode.output(DAY, PROBLEM, automata[0].toString());
	}
}
