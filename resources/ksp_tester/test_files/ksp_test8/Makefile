#
# Makefile for Ninja Test
#

SRC = njlisp.nj
ASM = $(patsubst %.nj,%.asm,$(SRC))
BIN = $(patsubst %.nj,%.bin,$(SRC))
MAP = $(patsubst %.nj,%.map,$(SRC))

MUSIMP = musimp.lsp
MUMATH = arith.mus algebra.ari

all:		$(ASM) $(BIN)

run:		njlisp.bin
		./njvm njlisp.bin

musimp:		njlisp.bin
		cat $(MUSIMP) - | ./njvm njlisp.bin

mumath:		njlisp.bin
		cat $(MUSIMP) $(MUMATH) - | ./njvm njlisp.bin

%.bin:		%.asm
		./nja --map $< $@ >$(MAP)

%.asm:		%.nj
		./njc --output $@ $<

clean:
		rm -f *~
		rm -f $(ASM)
		rm -f $(BIN)
		rm -f $(MAP)
