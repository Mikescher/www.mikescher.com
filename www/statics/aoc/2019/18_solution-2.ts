namespace AdventOfCode2019_18_2
{
	const DAY     = 18;
	const PROBLEM = 2;

	type P = [number, number];
	type PSet = [P, P, P, P];

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		AdventOfCode.setIntermedOutputSize("0.46vw");

		let grid = input
			.trim()
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.trim().split('').map(q => q.charCodeAt(0)) );

		grid[40][40] = "#".charCodeAt(0);

		grid[39][40] = "#".charCodeAt(0);
		grid[41][40] = "#".charCodeAt(0);
		grid[40][39] = "#".charCodeAt(0);
		grid[40][41] = "#".charCodeAt(0);

		let keys = grid.flatMap(p => p.filter(q => q>=97 && q<=122));

		await AdventOfCode.outputIntermed(  grid.map(p => p.map(q=>String.fromCharCode(q)).join("") ).join("\n")  );
		
		let dictionary: {[_:number]: ReachableKey[] } = {};

		dictionary[id([39,39])] = ReachableKeys(grid, [39,39], "");
		dictionary[id([41,39])] = ReachableKeys(grid, [41,39], "");
		dictionary[id([39,41])] = ReachableKeys(grid, [39,41], "");
		dictionary[id([41,41])] = ReachableKeys(grid, [41,41], "");

		for (let k of keys)
		{
			const pos = FindPositionOf(grid, k);
			dictionary[id(pos)] = ReachableKeys(grid, pos, "");
		}

		let positions: {[_:number]: P} = {};
		for (let k of keys) { positions[k] = FindPositionOf(grid, k); }

		let minimumSteps = CollectKeys(grid, dictionary, positions, [[39,39], [41,39], [39,41], [41,41]])

		AdventOfCode.output(DAY, PROBLEM, minimumSteps.toString());
	}

	function CollectKeys(grid: number[][], keyPaths: {[_:number]: ReachableKey[]}, positions: {[_:number]: P}, pos: P[])
	{
		let currentMinimum = Number.MAX_SAFE_INTEGER;

		let startingSet: PSet = [ pos[0], pos[1], pos[2], pos[3] ];

		let q: State[] = [];
		q.unshift(new State(startingSet, 0, 0));

		let visited = new Map<string, number>();
		let finishValue = 0;
		for (var i = 0; i < Object.entries(positions).length; ++i)
		{
			finishValue = finishValue | Math.floor(Math.pow(2, i));
		}

		while (q.length>0)
		{
			let state = q.pop()!;

			let valueTupleKey = state.strPositionsOwnedKeys();
			if (valueTupleKey in visited)
			{
				let steps = visited.get(valueTupleKey)!;

				if (steps <= state.Steps) continue;

				visited.set(valueTupleKey, state.Steps);
			}
			else
			{
				visited.set(valueTupleKey, state.Steps);
			}

			if (state.OwnedKeys === finishValue)
			{
				currentMinimum = Math.min(currentMinimum, state.Steps);
				continue;
			}

			for (let i=0; i < 4; i++)
			{
				for (let k of keyPaths[id(state.Positions[i])])
				{
					let ki = Math.floor(Math.pow(2, k.Key.charCodeAt(0) - "a".charCodeAt(0)));
					if ((state.OwnedKeys & ki) === ki || (k.Obstacles & state.OwnedKeys) != k.Obstacles) continue;

					let newOwned = state.OwnedKeys | ki;
					
					var newPos = state.Positions.slice() as PSet;
					newPos[i] = positions[k.Key.charCodeAt(0)];

					q.unshift(new State(newPos, newOwned, state.Steps + k.Distance));
				}
			}
		}

		return currentMinimum;
	}

	function id (p: P) { return p[1]*10000+p[0]; }

	function FindPositionOf(grid: number[][], needle: number): P
	{
		for(let y=0; y<grid.length; y++)
		for(let x=0; x<grid[y].length; x++)
		{
			if (grid[y][x] === needle) return [x, y];
		}
		throw "";
	}

	class State
	{
		Positions: PSet;
		OwnedKeys: number;
		Steps: number = 0;

		constructor(s: PSet, ok: number, ss: number) { this.Positions=s; this.OwnedKeys=ok; this.Steps = ss; }

		strPositionsOwnedKeys() 
		{ 
			return "" +
				this.Positions[0][0]+";" + 
				this.Positions[0][1]+";" + 
				this.Positions[1][0]+";" + 
				this.Positions[1][1]+";" + 
				this.Positions[2][0]+";" + 
				this.Positions[2][1]+";" + 
				this.Positions[3][0]+";" + 
				this.Positions[0][1]+";" + 
				this.OwnedKeys+";";
		}
	}

	function ReachableKeys(map: number[][], start: P, currentKeys: string): ReachableKey[]
	{
		let list: ReachableKey[] = [];
		let visited: Set<number> = new Set<number>();
		
		var q: P[] = [];
		var s: number[] = [];
		var o: number[] = [];
		q.unshift(start);
		s.unshift(0);
		o.unshift(0);

		while (q.length>0)
		{
			const pos  = q.pop()!;
			const dist = s.pop()!;
			let   obst = o.pop()!;

			if (visited.has(id(pos))) continue;
			visited.add(id(pos));

			var c = map[pos[1]][pos[0]];

			if (c>=97 && c<=122) // lower
			{
				let rk = new ReachableKey();
				rk.Distance = dist; rk.Key = String.fromCharCode(c); rk.Obstacles = obst;
				list.push(rk);
				pos_around(pos).forEach(p =>
				{
					q.unshift(p);
					s.unshift(dist+1);
					o.unshift(obst);
				});
			}
			else if (c>=65 && c<=90) // upper
			{
				pos_around(pos).forEach(p =>
				{
					q.unshift(p);
					s.unshift(dist+1);
					obst = obst | Math.floor(Math.pow(2, c-65))
					o.unshift(obst);
				});
			}
			else if (c === 46) // .
			{
				pos_around(pos).forEach(p =>
				{
					q.unshift(p);
					s.unshift(dist+1);
					o.unshift(obst);
				});
			}
			else if (c === 35) {}// #
			else throw "["+c+"]";
		}

		return list;
	}

	function pos_around(pos: P): P[]
	{
		return [
			[pos[0], pos[1]-1],
			[pos[0]-1, pos[1]],
			[pos[0]+1, pos[1]],
			[pos[0], pos[1]+1],
		];
	}

	class ReachableKey 
	{
		Key: string = "";
		Distance: number = 0;
		Obstacles: number = 0;
	}
}
