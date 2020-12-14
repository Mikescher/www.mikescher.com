use crate::common::AdventOfCodeDay;

use std::collections::HashMap;

pub struct Day14 {
    input: Vec<String>,
}

impl Day14 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/14_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str
                        .lines()
                        .map(|p| String::from(p))
                        .collect::<Vec<String>>();

        Self {
            input: lines
        }
    }
}

impl AdventOfCodeDay for Day14 {

    fn task_1(&self) -> String {

        let mut mask_set:   u64 = 0;
        let mut mask_unset: u64 = 0;

        let mut mem: HashMap<u64, u64> = HashMap::new();

        for line in &self.input {

            if line.starts_with("mask = ") {

                let strmask = &line[7..];

                mask_set   = u64::from_str_radix(&strmask.replace("X", "0"),  2).unwrap();
                mask_unset = u64::from_str_radix(&strmask.replace("X", "1"),  2).unwrap();

                verboseln!("Mask: {} -> set:{} | unset:{}", strmask, mask_set, mask_unset);

            } else if line.starts_with("mem[") {

                let addr  = line.replace("mem[", "").replace("] =", "").split(' ').nth(0).unwrap().parse::<u64>().unwrap();
                let value = line.replace("mem[", "").replace("] =", "").split(' ').nth(1).unwrap().parse::<u64>().unwrap();

                let masked_val = (value | mask_set) & mask_unset;

                mem.insert(addr, masked_val);
                
                verboseln!("Set: {} := {} (orig: {})", addr, masked_val, value);
            }

        }

        return mem.iter().map(|(_,v)| v).sum::<u64>().to_string();
    }

    fn task_2(&self) -> String  {

        let mask_36: u64 = 0b111111_111111_111111_111111_111111_111111;

        let mut addr: Vec<(u64,u64)> = Vec::with_capacity(1024);

        let mut mem: HashMap<u64, u64> = HashMap::new();

        for line in &self.input {

            if line.starts_with("mask = ") {

                let strmask = &line[7..];

                let mask_set   = u64::from_str_radix(&strmask.replace("X", "0"),  2).unwrap();
                let mask_unset = 0u64;

                
                verboseln!("{0} | {0}", strmask);
                verboseln!("{:0>36b} | {:0>36b}", mask_set, mask_unset);
                verboseln!();

                let floats = strmask.chars().rev().enumerate().filter(|(_,v)| *v == 'X').map(|(i,_)| i).collect::<Vec<usize>>();

                addr.clear();

                for fmask in 0..(2u64.pow(floats.len() as u32)) {

                    let mut nf_mask_set   = mask_set;
                    let mut nf_mask_unset = mask_unset;

                    let mut ii = 0;
                    for i in &floats {

                        let fbmask = 1u64 << *i;

                        if fmask & (1<<ii) != 0 {
                            nf_mask_set = nf_mask_set | fbmask;
                        } else {
                            nf_mask_unset = nf_mask_unset | fbmask;
                        }

                        ii += 1;
                    }

                    addr.push((nf_mask_set, nf_mask_unset));
                    verboseln!("{:0>36b} | {:0>36b}   ( {:0>10b} )", nf_mask_set, nf_mask_unset, fmask);
                }
                verboseln!();
                verboseln!();

            } else if line.starts_with("mem[") {

                let val_addr  = line.replace("mem[", "").replace("] =", "").split(' ').nth(0).unwrap().parse::<u64>().unwrap();
                let val_value = line.replace("mem[", "").replace("] =", "").split(' ').nth(1).unwrap().parse::<u64>().unwrap();

                for (mset,munset) in &addr {
                    let masked_addr = ((val_addr | mset) & !munset) & mask_36;
                    mem.insert(masked_addr, val_value);
                }
                
                verboseln!("Write into {} mems", addr.len());
                verboseln!();
            }
        }

        return mem.iter().map(|(_,v)| v).sum::<u64>().to_string();
    }
}