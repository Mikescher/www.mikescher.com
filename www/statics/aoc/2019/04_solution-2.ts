namespace AdventOfCode2019_04_2
{
	const DAY     = 4;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const min = parseInt(input.split('-')[0]);
		const max = parseInt(input.split('-')[1]);

		let rcount = 0;

		for(let d0=0; d0<=9; d0++)
		{
			const v0 = d0 * 100000

			if (v0+99999 <= min) continue;
			if (v0       >= max) continue;

			for(let d1=d0; d1<=9; d1++)
			{
				const v1 = v0 + d1 * 10000;

				if (v1+9999 <= min) continue;
				if (v1      >= max) continue;

				for(let d2=d1; d2<=9; d2++)
				{
					const v2 = v1 + d2 * 1000;

					if (v2+999 <= min) continue;
					if (v2     >= max) continue;

					for(let d3=d2; d3<=9; d3++)
					{
						const v3 = v2 + d3 * 100;

						if (v3+99 <= min) continue;
						if (v3    >= max) continue;

						for(let d4=d3; d4<=9; d4++)
						{
							const v4 = v3 + d4 * 10;

							if (v4+9 <= min) continue;
							if (v4   >= max) continue;

							for(let d5=d4; d5<=9; d5++)
							{
								const v5 = v4 + d5 * 1;

								if (v5 <= min) continue;
								if (v5 >= max) continue;
								
								if (!eq(d0, d1, d2, d3, d4, d5)) continue;

								rcount++;
								AdventOfCode.outputConsole(v5);
							}
						}
					}
				}
			}
		}

		AdventOfCode.output(DAY, PROBLEM, rcount.toString());
	}

	function eq(a:number, b: number, c: number, d: number, e: number, f: number): boolean
	{
		if (        a==b && b!=c) return true;
		if (a!=b && b==c && c!=d) return true;
		if (b!=c && c==d && d!=e) return true;
		if (c!=d && d==e && e!=f) return true;
		if (d!=e && e==f        ) return true;

		return false;
	}
}
