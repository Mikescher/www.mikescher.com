namespace AdventOfCode2019_08_2
{
	const DAY     = 8;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		let data = input.trim().split("").map(p => parseInt(p));

		const layers = [];

		while (data.length>0) { layers.push(data.slice(0, 25*6)); data = data.slice(25*6); }

		let r = Array(25*6); 
		for(let i=0; i<25*6;i++) r[i]=2;
		
		for(let il = layers.length-1; il >= 0 ; il--)
		{
			for(let i=0; i<25*6;i++)
			{
				if (layers[il][i] == 2) continue;
				r[i] = layers[il][i];
			}
		}

		let str = "";
		for(let i=0; i<25*6;i++)
		{
			if (i>0 && i%25==0)str+="\n";

			if (r[i]===0) str += " ";
			if (r[i]===1) str += "#";
			if (r[i]===2) str += ".";
		}

		await AdventOfCode.outputIntermed(str);

		AdventOfCode.output(DAY, PROBLEM, "CJZLP"); // OCR -.-
	}
}
