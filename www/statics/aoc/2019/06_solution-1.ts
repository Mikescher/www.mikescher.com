namespace AdventOfCode2019_06_1
{
	const DAY     = 6;
	const PROBLEM = 1;

	class Body
	{
		name: string;
		children: Body[] = [];
		parent:   Body|null = null;

		constructor(n: string) { this.name = n; }
	}

	class StellarSystem
	{
		com: Body;
		bodies: { [key:string]:Body } = {};

		constructor() { this.com = new Body("COM"); this.bodies["COM"] = this.com; }

		private getOrCreate(name: string): Body 
		{
			if (name in this.bodies) return this.bodies[name];
			return this.bodies[name] = new Body(name);
		}

		public add(mastername: string, slavename: string)
		{
			const master = this.getOrCreate(mastername);
			const slave  = this.getOrCreate(slavename);

			if (slave.parent !== null) throw "slave already has master";
			slave.parent = master;

			master.children.push(slave);
		}

		public getChecksum(): number
		{
			return this.calcChecksum(this.com, 0);
		}

		private calcChecksum(master: Body, depth: number): number
		{
			let r = depth;
			for (const body of master.children)
			{
				r += this.calcChecksum(body, depth+1);
			}
			return r;
		}
	}

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const data = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => p.split(')'));

		let sys = new StellarSystem();

		for(const dat of data) sys.add(dat[0], dat[1]);

		AdventOfCode.output(DAY, PROBLEM, sys.getChecksum().toString());
	}
}
