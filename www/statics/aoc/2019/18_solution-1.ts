namespace AdventOfCode2019_18_1
{
	const DAY     = 18;
	const PROBLEM = 1;

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


		let str = "";
		for(let line of grid) 
		{
			str += line.map(p => 
				{
					if (p == 46) return " ";
					if (p == 35) return "\u2591";
					return String.fromCharCode(p);
				}).reduce((a,b)=>a+b)+"\n";
			await AdventOfCode.outputIntermed(str);
		}

		let map = new AOCMap(grid);

		await map.dump();

		await createReachabilityMap(map, "@", map.start, 0);
		for(let i=0;i<26;i++) await createReachabilityMap(map, String.fromCharCode(i+97), map.keys[i], 1);

		await map.dump();

		let best_path = (await findPaths(map))!;
		
		await map.dump();

		AdventOfCode.outputConsole(best_path[0] + " (" + map.getPathLength(best_path[1]) + ") --> " + best_path[1]);

		AdventOfCode.output(DAY, PROBLEM, best_path[0].toString());
	}

	async function createReachabilityMap(map: AOCMap, letter:string, pos: [number, number], dumpmode: number)
	{
		let quadrant: {[_:string]: [number, number]} = {};
		for(let i=0;i<26;i++) 
		{
			quadrant[String.fromCharCode(i+97)] = [ Math.sign(map.keys[i][0] - map.start[0]), Math.sign(map.keys[i][1] - map.start[1]) ];
		}

		const no_doors = new Array<boolean>(26).fill(false);
		map.reachability.set("@>@", [0, no_doors]);
		for(let i=0;i<26;i++) map.reachability.set(String.fromCharCode(i+97)+">"+String.fromCharCode(i+97), [0, no_doors]);

		let visited_map: { [_:number]: number } = {};

		let next: [number, number, boolean[], string[] ][] = []; // x, y, currently_passed_doors, currently_found_keys
		next.push([pos[0], pos[1], no_doors, ['@']]);

		let counter = 0;
		
		if (dumpmode===0 || dumpmode===1) await map.dumpWithFillAndNext(visited_map, next);

		for(;;)
		{
			let ls = next.slice();
			next = [];

			let updates = 0;
			for(let pos of ls)
			{
				const x = pos[0];
				const y = pos[1];

				let currently_passed_doors: boolean[] = pos[2];
				let currently_found_keys: string[]    = pos[3];

				const i = (y*10000000 + x);
				if (i in visited_map) { if (visited_map[i] < counter && visited_map[i]>4) throw "loop in map :("; continue; }

				visited_map[i] = counter;
				updates++;

				if (map.iskey([x,y]))
				{
					const key1 = letter;
					const key2 = String.fromCharCode(map.get([x, y]));

					{
						let dist = counter;
						const keys = currently_passed_doors;

						//if (key1 !== "@" && key2 !== "@")
						//{
						//	const q1 = quadrant[key1];
						//	const q2 = quadrant[key2];
//
						//	if (q1[0]*q2[0]*q1[1]*q2[1] === -1) dist -= 2; // big middle area
						//}


						map.reachability.set(key1+">"+key2, [ dist, keys ]);
						map.reachability.set(key2+">"+key1, [ dist, keys ]);

						AdventOfCode.outputConsole("Add reachability ("+key1+" <-> " + key2 + ") == " + dist);
						
						if (dumpmode===1) await map.dumpWithFillAndNext(visited_map, next);
					}

					currently_found_keys = currently_found_keys.slice();
					currently_found_keys.push(key2);
				}
				else if (map.isdoor([x,y]))
				{
					const v = map.get([x, y]);
					currently_passed_doors = currently_passed_doors.slice();
					currently_passed_doors[v-65] = true;
				}

				if (map.iswalkable([x-1, y]) && !(((y  )*10000000 + (x-1)) in visited_map)) next.push([x-1, y, currently_passed_doors, currently_found_keys]);
				if (map.iswalkable([x+1, y]) && !(((y  )*10000000 + (x+1)) in visited_map)) next.push([x+1, y, currently_passed_doors, currently_found_keys]);
				if (map.iswalkable([x, y-1]) && !(((y-1)*10000000 + (x  )) in visited_map)) next.push([x, y-1, currently_passed_doors, currently_found_keys]);
				if (map.iswalkable([x, y+1]) && !(((y+1)*10000000 + (x  )) in visited_map)) next.push([x, y+1, currently_passed_doors, currently_found_keys]);
			}

			if (dumpmode===0) await map.dumpWithFillAndNext(visited_map, next);

			if (updates === 0) break;

			counter++;
		}

		await map.dumpWithFill(visited_map);

		return;
	}

	async function findPaths(map: AOCMap): Promise<[number, string]|null>
	{
		let queue: [string, boolean[], number, number, string][] = []; // < pos, keys, key_count, path_len, path >

		queue.push(["@", new Array<boolean>(26).fill(false), 0, 0, ""]);

		let best_result: [number, string]|null = null;

		let seen = new Set<string>();

		for(let ctr=1;;ctr++)
		{

			let [ pos, keys, key_count, path_len, path ] = queue.shift()!;

			let hskey = pos+keys.map(p=>p?1:0).join()+""+path_len;
			if (seen.has(hskey)) continue;
			seen.add(hskey);


			if (ctr %  100 === 0) AdventOfCode.outputConsole("[INTERMED] ["+path_len+"] " + path);
			if (ctr %  500 === 0) await AdventOfCode.sleep(0);

			if (key_count === 26)
			{
				if (best_result === null || best_result[0]>path_len) 
				{
					best_result = [path_len, path];
					AdventOfCode.outputConsole("[RESULT] ["+path_len+"] ==== " + path);
					//return [path_len, path];
				}
			}
			
			if (best_result !== null && best_result[0] < path_len) return best_result;

			let reachable = "abcdefghijklmnopqrstuvwxyz"
								.split('')
								.filter(p => !keys[p.charCodeAt(0)-97])
								.filter(p => map.isreachable(pos, p, keys))
								.map(p => [p, map.reachability.get(pos+">"+p)![0]] as [string, number] )
								.sort((a,b) => a[1] - b[1])
								;
			
			for(const [nextkey, steplen] of reachable)
			{
				let keys_copy = keys.slice();
				keys_copy[nextkey.charCodeAt(0)-97]=true;
				
				if (best_result!==null && best_result[0] < path_len+steplen) continue;

				array_insert(queue, [nextkey, keys_copy, key_count+1, path_len+steplen, path+nextkey]);
				//queue.push([nextkey, keys_copy, key_count+1, path_len+steplen, path+nextkey]);
				//queue.sort((a, b) => b[3] - a[3] );
			}

			if (queue.length===0) break;
		}

		return best_result;

	}

	function array_insert(array: [string, boolean[], number, number, string][], element: [string, boolean[], number, number, string]) 
	{
		function sortedIndex(array: [string, boolean[], number, number, string][], value: [string, boolean[], number, number, string]) 
		{
			var low = 0, high = array.length;
		
			while (low < high) {
				var mid = (low + high) >>> 1;
				if (array[mid][3] < value[3]) low = mid + 1;
				else high = mid;
			}
			return low;
		}
		
		array.splice(sortedIndex(array, element) + 1, 0, element);
		return array;
	}

	function key_except(base: boolean[], exc: boolean[])
	{
		let r = base;
		let cp = false;
		for(let i=0; i<26; i++)
		{
			if (exc[i] && base[i])
			{
				if (!cp) {r = base.slice(); cp=true; }
				r[i]=false;
			}
		}
		return r;
	}

	function key_combine(a: boolean[], b: boolean[])
	{
		let r = a;
		let cp = false;
		for(let i=0; i<26; i++)
		{
			if (b[i] && !r[i])
			{
				if (!cp) {r = a.slice(); cp=true; }
				r[i]=true;
			}
		}
		return r;
	}

	class AOCMap
	{
		grid:   number[][];
		width:  number;
		height: number;
		start:  [number, number];
		doors:  [number, number][];
		keys:   [number, number][];

		reachability: Map<string, [number, boolean[]]> = new Map<string, [number, boolean[]]>(); // [x;y] => [length;keys]

		constructor(g: number[][])
		{
			this.grid   = g;
			this.width  = g[0].length;
			this.height = g.length;
			this.doors  = new Array(26);
			this.keys   = new Array(26);
			this.start  = [-1, -1];

			for(let y=0; y<this.height;y++)
			for(let x=0; x<this.width;x++)
			{
				const v = String.fromCharCode(this.get([x,y]));
				if (v === "#") continue;
				if (v === ".") continue;
				if (v === "@") { this.start = [x, y]; continue; }

				if (v.charCodeAt(0) >= "A".charCodeAt(0) && v.charCodeAt(0) <= "Z".charCodeAt(0))
				{
					this.doors[v.charCodeAt(0) - "A".charCodeAt(0)] = [x,y];
					continue;
				}

				if (v.charCodeAt(0) >= "a".charCodeAt(0) && v.charCodeAt(0) <= "z".charCodeAt(0))
				{
					this.keys[v.charCodeAt(0) - "a".charCodeAt(0)] = [x,y];
					continue;
				}

				throw "input:"+v+":";
			}
		}

		getPathLength(path: string): number
		{
			path = "@" + path;

			let sum = 0;
			for (let i=1; i<path.length; i++)
			{
				sum += this.reachability.get(path.charAt(i-1)+">"+path.charAt(i))![0];
			}
			return sum;
		}

		isreachable(p0: string, p1: string, keys: boolean[]): boolean
		{
			const k_needed = this.reachability.get(p0+">"+p1)![1];
			for(let i=0; i<26; i++)
			{
				if (k_needed[i] && !keys[i]) return false;
			}
			return true;
		}

		get(pos: [number, number]): number {
			return this.grid[pos[1]][pos[0]];
		}
		
		iswalkable(pos: [number, number]): boolean {
			const v = this.get(pos);
			return (v !== 35 && v !== 64); // # && @
		}
		
		iskey(pos: [number, number]): boolean {
			const v = this.get(pos);
			return (v >= 97 && v <= 122); // a-z
		}
		
		isdoor(pos: [number, number]): boolean {
			const v = this.get(pos);
			return (v >= 65 && v <= 90); // A-Z
		}
		
		async dump()
		{
			let str = "";
			for(let y=0; y<this.height;y++)
			{
				for(let x=0; x<this.width;x++)
				{
					let v = this.get([x, y]);
					if (v == 46) str += " ";
					else if (v == 35) str += "\u2591";
					else str += String.fromCharCode(v);
				}
				str += "\n";
			}
			await AdventOfCode.outputIntermed(str);
		}
		
		async dumpWithFill(visited_map: { [_: number]: any; })
		{
			let str = "";
			for(let y=0; y<this.height;y++)
			{
				for(let x=0; x<this.width;x++)
				{
					const i = (y*10000000 + x);

					if (i in visited_map) str += "\u25cf"
					else
					{
						let v = this.get([x, y]);
						if (v == 46) str += " ";
						else if (v == 35) str += "\u2591";
						else str += String.fromCharCode(v);
					}
				}
				str += "\n";
			}
			await AdventOfCode.outputIntermed(str);
		}
		
		async dumpWithFillAndNext(visited_map: { [_: number]: any; }, next: [number, number, any, any][])
		{
			let str = "";
			for(let y=0; y<this.height;y++)
			{
				for(let x=0; x<this.width;x++)
				{
					const i = (y*10000000 + x);

					if (next.findIndex(p => p[0]==x && p[1]==y)>=0) str += "\u25cb"
					else if (i in visited_map) str += "\u25cf"
					else
					{
						let v = this.get([x, y]);
						if (v == 46) str += " ";
						else if (v == 35) str += "\u2591";
						else str += String.fromCharCode(v);
					}
				}
				str += "\n";
			}
			await AdventOfCode.outputIntermed(str);
		}
	}
}
