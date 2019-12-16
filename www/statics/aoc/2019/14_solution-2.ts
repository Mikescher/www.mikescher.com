namespace AdventOfCode2019_14_2
{
	const DAY     = 14;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		let recipes: { [_:string]:[number, [number, string][], string ] } = {};

		for (let line of input.split(new RegExp('\r?\n')).filter(p => p.trim().length > 0))
		{
			const left  = line.split(" => ")[0];
			const right = line.split(" => ")[1];

			const right_n = parseInt(right.split(" ")[0]);
			const right_v = right.split(" ")[1];

			recipes[right_v] = [ right_n, left.split(", ").map(p => [ parseInt(p.split(" ")[0]), p.split(" ")[1] ]  ), line ]; 
		}

		// binary search

		const target = 1_000_000_000_000;

		let lower = 1;
		let upper = 1_000_000_000_000;

		AdventOfCode.outputConsole(`Range: [${lower}  |  ${upper}]`);

		while(upper-lower>1)
		{
			const f = Math.floor((upper+lower) / 2);
			const o = calcOreRequirement(recipes, f);

			AdventOfCode.outputConsole(`${o} ORE  =>  ${f} FUEL`);

			if (o > target) {
				upper = f;
			} else if (o < target) {
				lower = f;
			} else {
				upper = lower = f; // jackpot
			}

			AdventOfCode.outputConsole(`Range: [${lower}  |  ${upper}]`);
		}

		AdventOfCode.output(DAY, PROBLEM, lower.toString());
	}

	function calcOreRequirement(recipes: { [_:string]:[number, [number, string][], string ] }, fuelcount: number): number
	{

		let missing : [number, string][] = [ [fuelcount, "FUEL"] ];
		let surplus : [number, string][] = [];

		while( missing.length>1 || missing[0][1] !== "ORE" )
		{
			missing = missing.filter(p => p[0]>0);
			surplus = surplus.filter(p => p[0]>0);

			//AdventOfCode.outputConsole("missing: [" + missing.map(p => p[0]+"|"+p[1]).reduce((a,b)=>a+"  "+b, "")+"]");
			//AdventOfCode.outputConsole("surplus: [" + surplus.map(p => p[0]+"|"+p[1]).reduce((a,b)=>a+"  "+b, "")+"]");

			let target = missing.pop();
			if (target === undefined) throw "undef??";

			if (target[1] === "ORE")
			{
				missing.push(target);
				missing = missing.reverse();
				target = missing.pop();
				if (target === undefined) throw "undef??";
			}

			const orig_recipe = recipes[target[1]];

			const factor = Math.max(1, Math.ceil(target[0] / orig_recipe[0]));
			let recipe: [number, [number, string][], string] = 
			[ 
				factor*orig_recipe[0],
				Object.assign([], orig_recipe[1]).map(p => [ factor*p[0], p[1] ] ),
				(""+factor+"*("+orig_recipe[2]+")")
			];

			if (target[0] > recipe[0])
			{
				missing.push([ target[0] - recipe[0], target[1] ]);
			}
			else if (target[0] < recipe[0])
			{
				let found=false;
				for(let i=0; i<surplus.length; i++)
				{
					if (surplus[i][1] === target[1]) 
					{
						surplus[i][0] += (recipe[0] - target[0]);
						found = true;
						break;
					}
				}
				if (!found) surplus.push([ (recipe[0] - target[0]), target[1] ]);
			}

			let incredentials = Object.assign([], recipe[1]);

			//AdventOfCode.outputConsole(recipe[2]);

			for(let icrd of incredentials)
			{
				let   incred_count = icrd[0];
				const incred_name  = icrd[1];
				for(let i=0; i<surplus.length; i++)
				{
					if (surplus[i][1] === incred_name)
					{
						if (surplus[i][0] >= incred_count)
						{
							surplus[i][0] -= incred_count;
							incred_count = 0;
						}
						else
						{
							incred_count -= surplus[i][0];
							surplus[i][0] = 0;
						}
					}
				}

				if (incred_count > 0)
				{
					let found=false;
					for(let i=0; i<missing.length; i++)
					{
						if (missing[i][1] === incred_name) 
						{
							missing[i][0] += incred_count;
							found = true;
							break;
						}
					}
					if (!found) missing.push([incred_count, incred_name]);
				}

				//AdventOfCode.outputConsole("");
			}
		}

		return missing[0][0];
	}
}
