namespace AdventOfCode2019_10_1
{
	const DAY     = 10;
	const PROBLEM = 1;

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

			AdventOfCode.outputConsole(`${((count>ac_max)?"+":" ")}[${cx}|${cy}]  :=  ${count}`);

			if (count>ac_max) ac_max=count;
		}

		AdventOfCode.output(DAY, PROBLEM, ac_max.toString());
	}

	function gcd(x: number, y: number) 
	{
		x = Math.abs(x);
		y = Math.abs(y);
		while(y) { var t = y; y = x % y; x = t; }
		return x;
	}
}
