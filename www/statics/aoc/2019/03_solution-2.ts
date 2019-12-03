namespace AdventOfCode2019_03_2
{
	const DAY     = 3;
	const PROBLEM = 2;

	class Mov
	{
		dir: string;
		len: number;

		constructor(v: string) { this.dir = v[0]; this.len = parseInt(v.substr(1)); }
	}

	class Pos
	{
		x: number;
		y: number;
		dist: number;

		constructor(x: number, y: number, d: number) { this.x = x; this.y = y; this.dist = d; }

		manhatten() {
			return Math.abs(this.x)+Math.abs(this.y);
		}

		ident() { return this.x*10000+this.y; }

		static manhattenCompare(a: Pos, b: Pos): number
		{
			const aa = a.manhatten();
			const bb = b.manhatten();
			if (aa>bb) return +1;
			if (aa<bb) return -1;
			return 0;
		}

		static stepCompare(a: Pos[], b: Pos[]): number
		{
			const aa = a[0].dist + a[1].dist;
			const bb = b[0].dist + b[1].dist;
			if (aa>bb) return +1;
			if (aa<bb) return -1;
			return 0;
		}
	}

	function getPath(movs: Mov[])
	{
		let r = [];

		let x = 0;
		let y = 0;

		let d = 0;
		for(let mov of movs)
		{
			for(let i=0; i < mov.len; i++)
			{
				d++;

				if (mov.dir == "U")y++;
				if (mov.dir == "R")x++;
				if (mov.dir == "D")y--;
				if (mov.dir == "L")x--;
				r.push(new Pos(x,y,d))
			}
		}

		return r;
	}

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const xin = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.split(",").map(q => new Mov(q)) )
			.map(p => getPath(p));

		const path1 = xin[0];
		const path2 = xin[1];

		let intersections = [];

		let p1hash: { [_:number]:Pos } = {};   

		for(let p1 of path1) p1hash[p1.ident()] = p1;

		for(let p2 of path2)
		{
			if (p2.ident() in p1hash) intersections.push([p1hash[p2.ident()], p2]);
		}

		intersections.sort((a,b) => Pos.stepCompare(a, b))

		AdventOfCode.output(DAY, PROBLEM, (intersections[0][0].dist + intersections[0][1].dist).toString());
	}
}
