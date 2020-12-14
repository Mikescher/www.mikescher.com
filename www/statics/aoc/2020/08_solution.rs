use crate::common::AdventOfCodeDay;

use itertools::Itertools;
use std::collections::HashSet;
use std::fmt::Display;

#[derive(Debug, Clone)]
struct HGCProgramm {
    code: Vec<HGCCommand>,
}

impl HGCProgramm {
    fn parse_program(codestr: String) -> HGCProgramm {
        HGCProgramm {
            code: codestr.lines().map(HGCCommand::parse).collect(),
        }
    }
}

#[derive(Debug, Clone)]
struct HGCCommand {
    cmdtype: HGCCommandType,
    argument:  i32,
}

impl HGCCommand {
    fn parse(line: &str) -> HGCCommand {
        let (str_cmd, str_arg) =  line.split(' ').collect_tuple::<(_, _)>().unwrap();
        HGCCommand {
            cmdtype: HGCCommandType::parse(str_cmd),
            argument: str_arg.parse::<i32>().unwrap(),
        }
    }
}

#[derive(Debug, PartialEq, Clone)]
enum HGCCommandType {
    NOP,
    ACC,
    JMP,
}

impl HGCCommandType {
    fn parse(val: &str) -> HGCCommandType {
        match val {
            "acc" => HGCCommandType::ACC,
            "jmp" => HGCCommandType::JMP,
            "nop" => HGCCommandType::NOP,
            _ => panic!("not a cmd")
        }
    }
}

impl Display for HGCCommandType {
    fn fmt(&self, f: &mut std::fmt::Formatter<'_>) -> std::fmt::Result {
        write!(f, "{:?}", self)
    }
}

#[derive(Debug)]
struct HGCMachineState {
    trace: bool,

    acc: i32,
    ip: usize,
}

impl HGCMachineState {
    fn new() -> HGCMachineState {
        HGCMachineState {
            trace: is_verbose!(),

            acc: 0,
            ip: 0,
        }
    }

    fn exec_step(&mut self, prog: &HGCProgramm) {
        self.exec_single(&prog.code[self.ip])
    }

    fn exec_single(&mut self, cmd: &HGCCommand) {
        if self.trace {
            verboseln!("ip: {: <4}  ||  cmd:[{}({: <5})]  (acc: {})", self.ip, cmd.cmdtype, cmd.argument, self.acc)
        }

        if cmd.cmdtype == HGCCommandType::NOP {
            self.ip += 1;
        } else if cmd.cmdtype == HGCCommandType::JMP {
            self.ip = (self.ip as i32 + cmd.argument) as  usize;
        } else if cmd.cmdtype == HGCCommandType::ACC {
            self.acc += cmd.argument;
            self.ip += 1;
        }
    }
}

pub struct Day08 {
    input: HGCProgramm,
}

impl Day08 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/08_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        Self {
            input: HGCProgramm::parse_program(input_str.to_owned().to_string())
        }
    }
    
    fn find_loop(prog: &HGCProgramm) -> (i32, bool) {
        let mut vm = HGCMachineState::new();

        let mut visited: HashSet<usize> = HashSet::new();
        visited.insert(vm.ip);

        loop {
            vm.exec_step(prog);
            if visited.contains(&vm.ip) {
                return (vm.acc, false);
            }
            visited.insert(vm.ip);

            if vm.ip == prog.code.len() {
                return (vm.acc, true);
            }
        }
    }
}

impl AdventOfCodeDay for Day08 {

    fn task_1(&self) -> String {
        return Day08::find_loop(&self.input).0.to_string();
    }

    fn task_2(&self) -> String  {
        for i in 0..self.input.code.len() {
            if self.input.code[i].cmdtype == HGCCommandType::ACC {
                continue;
            }

            let mut progclone = self.input.clone();

            if self.input.code[i].cmdtype == HGCCommandType::JMP {
                progclone.code[i] = HGCCommand {
                    cmdtype: HGCCommandType::NOP,
                    argument: self.input.code[i].argument,
                }
            } else if self.input.code[i].cmdtype == HGCCommandType::NOP {
                progclone.code[i] = HGCCommand {
                    cmdtype: HGCCommandType::JMP,
                    argument: self.input.code[i].argument,
                }
            } else {
                panic!();
            }

            if let (acc, true) = Day08::find_loop(&progclone) {
                return acc.to_string();
            }
        }
        
        panic!();
    }
}