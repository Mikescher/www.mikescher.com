namespace AdventOfCode2019_20_1
{
	const DAY     = 20;
	const PROBLEM = 1;

	type Point = [number, number];

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		AdventOfCode.setIntermedOutputSize("0.55vw");

		let grid = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.split('').map(q => q) );
		
		const width  = grid[0].length;
		const height = grid.length;

		let tunnels:     {[_:string]: [Point, Point]} = {};
		let tunnelsList: {[_:number]: Point} = {};
		let entry: Point = [0, 0];
		let exit: Point = [0, 0];

		for (let y=1; y<height-1; y++)
		for (let x=1; x<width-1;  x++)
		{
			let v = grid[y][x];

			if (isUpperChar(v))
			{

				let key;
				let pos: Point;
	
				if (grid[y-1][x] === "." && isUpperChar(grid[y+1][x]))
				{
					key = v + grid[y+1][x];
					pos = [x, y-1];
				}
				else if (grid[y][x+1] === "." && isUpperChar(grid[y][x-1]))
				{
					key = grid[y][x-1] + v;
					pos = [x+1, y];
				}
				else if (grid[y+1][x] === "." && isUpperChar(grid[y-1][x]))
				{
					key = grid[y-1][x] + v;
					pos = [x, y+1];
				} 
				else if (grid[y][x-1] === "." && isUpperChar(grid[y][x+1]))
				{
					key = v + grid[y][x+1];
					pos = [x-1, y];
				}
				else continue;
	
				if (key === "AA")
				{
					entry = pos;
					AdventOfCode.outputConsole("[AA] := " + point_to_str(pos));
				}
				else if (key === "ZZ")
				{
					exit = pos;
					AdventOfCode.outputConsole("[ZZ] := " + point_to_str(pos));
				}
				else if (key in tunnels)
				{
					tunnels[key][1] = pos;
					tunnelsList[id(tunnels[key][0])] = tunnels[key][1];
					tunnelsList[id(tunnels[key][1])] = tunnels[key][0];

					AdventOfCode.outputConsole("[PORTAL] := " + point_to_str(tunnels[key][0]) + " <--> " + point_to_str(tunnels[key][1]));
				}
				else 
				{
					tunnels[key] = [pos, [-1, -1]];
				}
			}
		}

		for (let y=0; y<height; y++)
		for (let x=0; x<width;  x++)
		{
			let v = grid[y][x];
			if (v === " ") v = "#";
			if (isUpperChar(v)) v = "#";
			grid[y][x] = v;
		}

		await AdventOfCode.outputIntermed(toStr(grid));
		
		// ------------------

		let distmap: {[id:number]: number} = {};

		let dqueue: [number, Point][] = [];
		dqueue.push([0, entry]);

		while (dqueue.length>0)
		{
			await AdventOfCode.outputIntermed(toStr2(grid, dqueue, tunnelsList));
			//await AdventOfCode.sleep(1000);

			const [dist, pt] = dqueue.shift()!;
			const [ptx, pty] = pt;
			let ptid = id(pt);
			
			if (ptid in distmap && distmap[ptid] <= dist) continue;

			distmap[ptid] = dist;

			if (grid[pty-1][ptx] === '.') dqueue.push([ dist+1, [ptx, pty-1] ]);
			if (grid[pty][ptx+1] === '.') dqueue.push([ dist+1, [ptx+1, pty] ]);
			if (grid[pty+1][ptx] === '.') dqueue.push([ dist+1, [ptx, pty+1] ]);
			if (grid[pty][ptx-1] === '.') dqueue.push([ dist+1, [ptx-1, pty] ]);

			if (ptid in tunnelsList) dqueue.push([dist+1, tunnelsList[ptid]]);
		}

		await AdventOfCode.outputIntermed(toStr(grid));

        AdventOfCode.output(DAY, PROBLEM, distmap[id(exit)].toString());
	}

	function id (p: Point) { return p[1]*10000+p[0]; }

	function isUpperChar(c: string): boolean
	{
		return c.charCodeAt(0) >= "A".charCodeAt(0) && c.charCodeAt(0) <= "Z".charCodeAt(0);
	}

	function toStr(grid: string[][]): string
	{
		return grid.map(p => p.join("") ).join("\n");
	}

	function toStr2(grid: string[][], highlights: [any, Point][], tunnels: {[_:number]: Point}): string
	{
		const width  = grid[0].length;
		const height = grid.length;

		let str = "";
		for (let y=0; y<height; y++)
		{
			for (let x=0; x<width;  x++)
			{
				if (highlights.some( p => p[1][0] === x && p[1][1] === y )) str += "O";
				else if (id([x,y]) in tunnels) str += "@";
				else str += grid[y][x];
			}
			str += "\n";
		}

		return str
	}

	function point_to_str (p: Point) { return `[${p[0]}|${p[1]}]`; }
}
