namespace AdventOfCode2019_24_2
{
	const DAY     = 24;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		AdventOfCode.setIntermedOutputSize("0.70vw");

		const grid0 = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.trim().split('').map(q => q==='#'));

		let world: {[_:number]:boolean} = {};
		for(let y=0; y<5; y++)	for(let x=0; x<5; x++) world[id(x, y, 0)] = grid0[y][x];

		let minD = -1;
		let maxD = +1;

		await AdventOfCode.outputIntermed(tostr2(world, minD, maxD));
		await AdventOfCode.sleepIfIntermed(500);

		for(let i=0; i<200; i++)
		{
			[minD, maxD] = step(world, minD, maxD);

			await AdventOfCode.outputIntermed(tostr2(world, minD, maxD));
			await AdventOfCode.sleepIfIntermed(50);
		}

		let count = Object.values(world).filter(p => p).length;

		AdventOfCode.output(DAY, PROBLEM, count.toString());
	}

	function tostr1(world: {[_:number]:boolean}, minD: number, maxD: number): string
	{
		let str = "";

		for(let d=minD; d<=maxD; d++)
		{
			str += "Depth "+d+":\n";
			for(let y=0; y<5; y++)
			{
				for(let x=0; x<5; x++)
				{
					str += (world[id(x, y, d)] === true) ? "#" : ".";
				}
				str += "\n";
			}
			str += "\n";
		}
		return str;
	}

	function tostr2(world: {[_:number]:boolean}, minD: number, maxD: number): string
	{
		let str = "";

		for (let y = 0; y<11*6; y++)
		{
			for (let x = 0; x<19*6; x++)
			{
				let mx = x%6;
				let my = y%6;
				if (mx===5 || my === 5) str += " "
				else if (mx===2 && my === 2) str += "?"
				else
				{
					let md = Math.floor(y/6) * 19 + Math.floor(x/6) - Math.floor((19*11)/2);

					str += (world[id(mx, my, md)] === true) ? "#" : ".";
				}
			}
			str += "\n";
		}
		return str;
	}

	function id(x: number, y: number, depth: number): number
	{
		return depth*100 + x*10 + y;
	}

	function step(world: {[_:number]:boolean}, minD: number, maxD: number): [number, number]
	{
		let newminD = minD;
		let newmaxD = minD;

		let diff: [number, boolean, number][] = [];

		for(let d=minD; d<=maxD; d++)
		for(let y=0;    y<5;     y++)
		for(let x=0;    x<5;     x++)
		{
			if (x === 2 && y === 2) continue;

			let me_id = id(x, y, d);
			let me = (world[me_id] === true);

			let adjac = 0;
			if (x>0 && world[id(x-1, y,   d)] === true) adjac++;
			if (y>0 && world[id(x,   y-1, d)] === true) adjac++;
			if (x<4 && world[id(x+1, y,   d)] === true) adjac++;
			if (y<4 && world[id(x,   y+1, d)] === true) adjac++;

			if (x === 0 && world[id(1, 2, d-1)] === true) adjac++; // WEST  OUTER
			if (y === 0 && world[id(2, 1, d-1)] === true) adjac++; // NORTH OUTER
			if (x === 4 && world[id(3, 2, d-1)] === true) adjac++; // EAST  OUTER
			if (y === 4 && world[id(2, 3, d-1)] === true) adjac++; // SOUTH OUTER

			if (x === 2 && y === 1) // NORTH INNER
			{
				if (world[id(0, 0, d+1)] === true) adjac++;
				if (world[id(1, 0, d+1)] === true) adjac++;
				if (world[id(2, 0, d+1)] === true) adjac++;
				if (world[id(3, 0, d+1)] === true) adjac++;
				if (world[id(4, 0, d+1)] === true) adjac++;
			}
			if (x === 3 && y === 2) // EAST INNER
			{
				if (world[id(4, 0, d+1)] === true) adjac++;
				if (world[id(4, 1, d+1)] === true) adjac++;
				if (world[id(4, 2, d+1)] === true) adjac++;
				if (world[id(4, 3, d+1)] === true) adjac++;
				if (world[id(4, 4, d+1)] === true) adjac++;
			}
			if (x === 2 && y === 3) // SOUTH INNER
			{
				if (world[id(0, 4, d+1)] === true) adjac++;
				if (world[id(1, 4, d+1)] === true) adjac++;
				if (world[id(2, 4, d+1)] === true) adjac++;
				if (world[id(3, 4, d+1)] === true) adjac++;
				if (world[id(4, 4, d+1)] === true) adjac++;
			}
			if (x === 1 && y === 2) // WEST INNER
			{
				if (world[id(0, 0, d+1)] === true) adjac++;
				if (world[id(0, 1, d+1)] === true) adjac++;
				if (world[id(0, 2, d+1)] === true) adjac++;
				if (world[id(0, 3, d+1)] === true) adjac++;
				if (world[id(0, 4, d+1)] === true) adjac++;
			}

			if (me && adjac !== 1) diff.push([me_id, false, d]); // A bug dies (becoming an empty space) unless there is exactly one bug adjacent to it.
			else if (!me && (adjac === 1 || adjac === 2)) diff.push([me_id, true, d]); // An empty space becomes infested with a bug if exactly one or two bugs are adjacent to it.
		}

		for (const [id, val, depth] of diff)
		{
			world[id] = val;
			if (depth <= newminD) newminD = depth-1;
			if (depth >= newmaxD) newmaxD = depth+1;
		}

		return [newminD, newmaxD];
	}
}
