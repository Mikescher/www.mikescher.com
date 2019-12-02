namespace AdventOfCode2019_01_2
{
	const DAY     = 1;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const fuel = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => parseInt(p))
			.map(mass => 
			{
				let fuel = Math.floor(mass / 3) - 2;
				let lastfuel = fuel;
				for (; ; )
				{
					let newfuel = Math.floor(lastfuel / 3) - 2;
					if (newfuel <= 0) break;
					fuel += newfuel;
					lastfuel = newfuel;
				}
				return fuel;
			})
			.reduce((a,b) => a+b);

			AdventOfCode.output(DAY, PROBLEM, fuel.toString());
	}
}
