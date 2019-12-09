namespace AdventOfCode2019_08_1
{
	const DAY     = 8;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		let data = input.trim().split("").map(p => parseInt(p));

		const layers = [];

		while (data.length>0) { layers.push(data.slice(0, 25*6)); data = data.slice(25*6); }

		let zc = 9999999999;
		let vv = -1;
		
		for(let i = 0; i < layers.length; i++)
		{
			const _zc = layers[i].filter(p => p==0).length;
			const _vv = layers[i].filter(p => p==1).length * layers[i].filter(p => p==2).length;

			console.log("["+i+"] => "+_zc+"  ("+_vv+")");
			if (_zc < zc) { zc=_zc; vv = _vv; }
		}

		AdventOfCode.output(DAY, PROBLEM, vv.toString());
	}
}
