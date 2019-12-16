namespace AdventOfCode2019_12_2
{
	const DAY     = 12;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		let moons = input
			.trim()
			.split(new RegExp('\r?\n'))
			.map(p => p.replace(new RegExp('[<>\\sxyz=]', 'g'), ""))
			.map(p => p.split(",").map(p => parseInt(p)))
			.map(p => new Moon(p[0], p[1], p[2]));

		let cycletimes = [];

		for(let dim=0; dim<3; dim++)
		{
			let moons1d = moons.map(m => Moon1D.createFromMoon(m, dim));

			const cycle = getCycleTime(moons1d);
			AdventOfCode.outputConsole(`CycleTime Dim[${dim}] ==> ${cycle}`);

			cycletimes.push(cycle);
		}

		const totalctime = lcm(cycletimes)

		AdventOfCode.output(DAY, PROBLEM, totalctime.toString());
	}

	function lcm(v: number[]) // least common multiple
	{
		return v.map(p => BigInt(p)).reduce((a,b) => lcm2(a,b));
	}

	function lcm2(a: bigint, b: bigint): bigint // least common multiple
	{
		return (a*b)/gcd2(a,b);
	}

	function gcd(v: bigint[]): bigint 
	{
		return v.reduce((a,b) => gcd2(a,b));
	}

	function gcd2(x: bigint, y: bigint): bigint
	{
		x = (x<0) ? (-x) : (x);
		y = (y<0) ? (-y) : (y);
		while(y) { var t = y; y = x % y; x = t; }
		return x;
	}

	function getCycleTime(moons: Moon1D[]): number
	{
		const orig = moons.map(m => m.clone());

		for(let time=0;; time++)
		{
			step(moons)

			if (eq(orig, moons)) return time+1;
		}
	}

	function eq(a: Moon1D[], b: Moon1D[]): boolean 
	{
		for(let i=0; i<a.length; i++)
		{
			if (a[i].pos != b[i].pos) return false;
			if (a[i].vel != b[i].vel) return false;
		}
		return true;
	}

	function step(moons: Moon1D[])
	{
		for(let i1=0;    i1<moons.length; i1++)
		for(let i2=i1+1; i2<moons.length; i2++)
		{
			if (moons[i1].pos<moons[i2].pos) { moons[i1].vel++; moons[i2].vel--; }
			if (moons[i1].pos>moons[i2].pos) { moons[i1].vel--; moons[i2].vel++; }
		}

		for(let i=0; i<moons.length; i++)
		{
			moons[i].pos += moons[i].vel;
		}

	}

	class Moon1D
	{
		pos: number;
		vel: number;

		constructor(p: number, v:number)
		{
			this.pos=p;
			this.vel=v;
		}

		static createFromMoon(m: Moon, idx: number): Moon1D
		{
			if (idx == 0) { return new Moon1D(m.x, m.dx); }
			if (idx == 1) { return new Moon1D(m.y, m.dy); }
			if (idx == 2) { return new Moon1D(m.z, m.dz); }
			throw "Invalid index";
		}

		public clone(): Moon1D 
		{
			return new Moon1D(this.pos, this.vel);
		}
	}

	class Moon
	{
		x: number;
		y: number;
		z: number;
		
		dx: number = 0;
		dy: number = 0;
		dz: number = 0;

		constructor(x: number, y: number, z: number)
		{
			this.x=x;
			this.y=y;
			this.z=z;
		}

		public toString(): string {
			return `pos=<x=${this.x}, y=${this.y}, z=${this.z}>, vel=<x=${this.dx}, y=${this.dy}, z=${this.dz}> [pot=${this.getPotEnergy()}|kin=${this.getKinEnergy()}] => ${this.getEnergy()}`;
		}

		public getPotEnergy(): number {
			return Math.abs(this.x)+Math.abs(this.y)+Math.abs(this.z);
		}

		public getKinEnergy(): number {
			return Math.abs(this.dx)+Math.abs(this.dy)+Math.abs(this.dz);
		}

		public getEnergy(): number {
			return this.getPotEnergy() * this.getKinEnergy();
		}
	}
}
