namespace AdventOfCode2019_20_2
{
	const DAY     = 20;
	const PROBLEM = 2;

	type Point = [number, number];

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		AdventOfCode.setIntermedOutputSize("0.35vw");

		let grid = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.split('').map(q => q) );
		
		const width  = grid[0].length;
		const height = grid.length;

		let tunnels:     {[_:string]: [Point, Point]} = {};
		let tunnelsList: {[_:number]: [boolean, Point]} = {};
		let entry: Point = [0, 0];
		let exit: Point = [0, 0];

		for (let y=1; y<height-1; y++)
		for (let x=1; x<width-1;  x++)
		{
			let v = grid[y][x];

			if (isUpperChar(v))
			{
				let isinner = x>3 && y>3 && x<width-3 && y<height-3;

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
					if (isinner) tunnels[key][0] = pos;
					else         tunnels[key][1] = pos;
					tunnelsList[id(tunnels[key][0])] = [true, tunnels[key][1]];  // down
					tunnelsList[id(tunnels[key][1])] = [false, tunnels[key][0]]; // up

					AdventOfCode.outputConsole("[PORTAL] := " + point_to_str(tunnels[key][0]) + " --> " + point_to_str(tunnels[key][1]));
				}
				else 
				{
					if (isinner) tunnels[key] = [pos, [-1, -1]];
					else         tunnels[key] = [[-1, -1], pos];
				}
			}
		}

		for (let y=0; y<height; y++)
		for (let x=0; x<width;  x++)
		{
			let v = grid[y][x];
			if (isUpperChar(v)) v = " ";
			grid[y][x] = v;
		}

		await AdventOfCode.outputIntermed(toStr(grid));
		
		// ------------------

		let distmap: {[id:number]: number} = {};

		let dqueue: [number, number, Point][] = []; //<len, depth, pos>
		dqueue.push([0, 0, entry]);

		let last_dist = -1;
		while (dqueue.length>0)
		{

			const [dist, depth, pt] = dqueue.shift()!;
			const [ptx, pty] = pt;
			let ptid2 = id2(pt, depth);
			let ptid1 = id(pt);
			
			if (ptid2 in distmap && distmap[ptid2] <= dist) continue;

			if (dist !== last_dist)
			{
				await AdventOfCode.outputIntermed(toStr2(grid, dqueue, tunnelsList)+"\n\n" + dist);
				last_dist = dist;
			}

			if (depth === 0 && ptx === exit[0] && pty === exit[1])
			{
				AdventOfCode.output(DAY, PROBLEM, dist.toString());
				await AdventOfCode.outputIntermed(toStr(grid));
				return;
			}

			distmap[ptid2] = dist;

			if (grid[pty-1][ptx] === '.') dqueue.push([ dist+1, depth, [ptx, pty-1] ]);
			if (grid[pty][ptx+1] === '.') dqueue.push([ dist+1, depth, [ptx+1, pty] ]);
			if (grid[pty+1][ptx] === '.') dqueue.push([ dist+1, depth, [ptx, pty+1] ]);
			if (grid[pty][ptx-1] === '.') dqueue.push([ dist+1, depth, [ptx-1, pty] ]);

			if (ptid1 in tunnelsList) 
			{
				const [tunnel_dir, tunnel_pos] = tunnelsList[ptid1];
				if (depth ===0 && !tunnel_dir) { /* wall */ }
				else dqueue.push([dist+1, depth + (tunnel_dir ? 1 : -1), tunnel_pos]);
			}
		}


	}

	function id (p: Point) { return p[1]*10000+p[0]; }

	function id2(p: Point, d: number) { return p[1]*1000000+1000*p[0]+d; }

	function isUpperChar(c: string): boolean
	{
		return c.charCodeAt(0) >= "A".charCodeAt(0) && c.charCodeAt(0) <= "Z".charCodeAt(0);
	}

	function toStr(grid: string[][]): string
	{
		return grid.map(p => p.join("") ).join("\n");
	}

	function toStr2(grid: string[][], highlights: [any, any, Point][], tunnels: {[_:number]: [any, Point]}): string
	{
		const width  = grid[0].length;
		const height = grid.length;

		let str = "";
		for (let y=0; y<height; y++)
		{
			for (let x=0; x<width;  x++)
			{
				if (highlights.some( p => p[2][0] === x && p[2][1] === y )) str += "O";
				else if (id([x,y]) in tunnels) str += "@";
				else str += grid[y][x];
			}
			str += "\n";
		}

		return str
	}

	function point_to_str (p: Point) { return `[${p[0]}|${p[1]}]`; }
}
