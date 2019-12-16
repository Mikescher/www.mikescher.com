namespace AdventOfCode2019_12_1
{
	const DAY     = 12;
	const PROBLEM = 1;

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

		for(let i=0; i<1000;i++)
		{
			output(i, moons);
			
			step(moons);
		}

		output(1000, moons);

		const energy = moons.map(m => m.getEnergy()).reduce((a,b) => a+b);

		AdventOfCode.output(DAY, PROBLEM, energy.toString());
	}

	function output(i: number, moons: Moon[])
	{
		AdventOfCode.outputConsole("========  "+i+"  ========");
		for(let m of moons) AdventOfCode.outputConsole(m.toString());
		AdventOfCode.outputConsole();
	}

	function step(moons: Moon[])
	{
		for(let i1=0;    i1<moons.length; i1++)
		for(let i2=i1+1; i2<moons.length; i2++)
		{
			if (moons[i1].x<moons[i2].x) { moons[i1].dx++; moons[i2].dx--; }
			if (moons[i1].x>moons[i2].x) { moons[i1].dx--; moons[i2].dx++; }

			if (moons[i1].y<moons[i2].y) { moons[i1].dy++; moons[i2].dy--; }
			if (moons[i1].y>moons[i2].y) { moons[i1].dy--; moons[i2].dy++; }

			if (moons[i1].z<moons[i2].z) { moons[i1].dz++; moons[i2].dz--; }
			if (moons[i1].z>moons[i2].z) { moons[i1].dz--; moons[i2].dz++; }
		}

		for(let i=0; i<moons.length; i++)
		{
			moons[i].x += moons[i].dx;
			moons[i].y += moons[i].dy;
			moons[i].z += moons[i].dz;
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
