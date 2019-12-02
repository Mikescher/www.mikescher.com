namespace AdventOfCode2019_01_1
{
	const DAY     = 1;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const fuel = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => parseInt(p))
			.map(p => Math.floor(p/3) - 2)
			.reduce((a,b) => a+b);

			AdventOfCode.output(DAY, PROBLEM, fuel.toString());
	}
}
