package advent

import (
	"AdventOfCode2021/util"
	"math"
	"strconv"
)

func Day1Part1(ctx *util.AOCContext) (string, error) {

	incCount := 0

	val := int64(math.MaxInt64)
	for _, v := range ctx.InputLines() {
		num, err := strconv.ParseInt(v, 10, 64)
		if err != nil {
			return "", err
		}

		if val < num {
			incCount++
		}
		val = num
	}

	return strconv.Itoa(incCount), nil
}

func Day1Part2(ctx *util.AOCContext) (string, error) {

	incCount := 0

	input := ctx.InputLines()

	prev := int64(math.MaxInt64)

	sw0 := int64(0)
	sw1 := int64(0)
	sw2 := int64(0)

	for i, v := range input {
		num, err := strconv.ParseInt(v, 10, 64)
		if err != nil {
			return "", err
		}

		sw0 = sw1
		sw1 = sw2
		sw2 = num

		val := sw0 + sw1 + sw2

		if i > 2 && prev < val {
			incCount++
			//fmt.Printf("%d < %d + %d + %d\n", prev, sw0, sw1, sw2)
		}
		prev = val
	}

	return strconv.Itoa(incCount), nil
}
