namespace AdventOfCode2019_24_1
{
	const DAY     = 24;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		AdventOfCode.setIntermedOutputSize("5.00vw");

		let grid = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.trim().split('').map(q => q==='#'));

		await AdventOfCode.outputIntermed(tostr(grid));

		let hist: {[_:number]:boolean} = {};
		hist[biodiv(grid)] = true;

		for(;;)
		{
			grid = step(grid);
			let bd = biodiv(grid);
			if (bd in hist)
			{
				AdventOfCode.output(DAY, PROBLEM, bd.toString());
				return;
			}
			hist[bd] = true;

			await AdventOfCode.outputIntermed(tostr(grid));
		}
	}

	function tostr(grid: boolean[][]): string
	{
		return grid.map(p => p.map(q => q ? "#" : ".").join("") ).join("\n");
	}

	function biodiv(grid: boolean[][]): number
	{
		let n = 0;
		for(let y=0; y<5; y++)
		for(let x=0; x<5; x++)
		{
			n += grid[y][x] ? Math.pow(2, y*5+x) : 0;
		}
		return n;
	}

	function step(grid: boolean[][]): boolean[][]
	{
		let g2 = [
			[false, false, false, false, false],
			[false, false, false, false, false],
			[false, false, false, false, false],
			[false, false, false, false, false],
			[false, false, false, false, false]
		];

		for(let y=0; y<5; y++)
		for(let x=0; x<5; x++)
		{
			let adjac = 0;
			if (x>0 && grid[y][x-1]) adjac++;
			if (y>0 && grid[y-1][x]) adjac++;
			if (x<4 && grid[y][x+1]) adjac++;
			if (y<4 && grid[y+1][x]) adjac++;

			if (grid[y][x] && adjac !== 1) g2[y][x] = false; // A bug dies (becoming an empty space) unless there is exactly one bug adjacent to it.
			else if (!grid[y][x] && (adjac === 1 || adjac === 2)) g2[y][x] = true; // An empty space becomes infested with a bug if exactly one or two bugs are adjacent to it.
			else g2[y][x] = grid[y][x]; // Otherwise, a bug or empty space remains the same.
		}
		return g2;
	}
}
