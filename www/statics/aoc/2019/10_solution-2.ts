namespace AdventOfCode2019_10_2
{
	const DAY     = 10;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;
		input = input.trim();

		let data: { [_:number]:[number,number,boolean] } = {};

		const width  = input.split(new RegExp('\r?\n'))[0].length;
		const height = input.split(new RegExp('\r?\n')).length;
		
		let x=0;
		let y=0;
		for(let i=0; i<input.length;i++)
		{
			if (input[i]=="\r") continue;
			if (input[i]=="\n") { x=0;y++; continue; }
			data[y*10000+x] = [x, y, input[i]==="#"];
			x++;
		}

		let ac_max = -1;
		let ac_x = -1;
		let ac_y = -1;

		for(let cy=0; cy<height;cy++)
		for(let cx=0; cx<width;cx++)
		{
			if (!data[cy*10000+cx][2]) continue;

			// same  [dx,dy]/gcd  ===  hiding each other
			const count = Object.entries(data)
								.filter(p => p[1][2])
								.map(p => [cx-p[1][0], cy-p[1][1]])
								.filter(p => p[0] != 0 || p[1] != 0)
								.map(p => { const div = gcd(p[0], p[1]); return [ p[0]/div, p[1]/div ] })
								.map(p => p[0] * 10000 + p[1])
								.sort((a, b) => a - b).filter((v,i,s) => s.indexOf(v)===i) // unique
								.length;

			if (count>ac_max) { ac_max=count; ac_x=cx; ac_y=cy; }
		}

		AdventOfCode.outputConsole(`[${ac_x}|${ac_y}]  :=  ${ac_max}`);

		//-------------------------

		let asteroids = Object.entries(data)
			.filter(p => p[1][2])
			.map(p => [ p[1][0]-ac_x, p[1][1]-ac_y ])
			.filter(p => p[0] != 0 || p[1] != 0)            // rel_x | rel_y | norm_x |  norm_y |  dist | angle |                                          processed | x |        y |        order
			.map(p => { const div = gcd(p[0], p[1]); return [ p[0],    p[1],   p[0]/div, p[1]/div, div,   (Math.atan2(p[0], -p[1])+Math.PI*2)%(Math.PI*2), 1,          ac_x+p[0], ac_y+p[1]                  ] })
			.map(p => { const div = gcd(p[0], p[1]); return [ p[0],    p[1],   p[2],     p[3],     p[4],  p[5],                                            p[6],       p[7],      p[8],      p[5]*10000+p[4] ] })
			.sort((a, b) => a[9] - b[9])

		let ldx = -1;
		let ldy = -1;

		let idx=1;
		for(let i=0; i<asteroids.length; i++)
		{
			if (asteroids[i][6] === 0) continue;
			if (ldx==asteroids[i][2] && ldy==asteroids[i][3]) continue;

			AdventOfCode.outputConsole(`${idx} => [${asteroids[i][7]}|${asteroids[i][8]}]   /[${asteroids[i][0]}|${asteroids[i][1]}] @ ${asteroids[i][5]}:${asteroids[i][4]}`);

			ldx = asteroids[i][2];
			ldy = asteroids[i][3];
			asteroids[i][6] = 0;

			if (idx == 200)
			{
				AdventOfCode.output(DAY, PROBLEM, (asteroids[i][7]*100 + asteroids[i][8]).toString());
				return;
			}
			
			idx++;
		}
		
		AdventOfCode.output(DAY, PROBLEM, "ERR");
	}

	function gcd(x: number, y: number) 
	{
		x = Math.abs(x);
		y = Math.abs(y);
		while(y) { var t = y; y = x % y; x = t; }
		return x;
	}
}
