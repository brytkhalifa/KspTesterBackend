//
// version
//
	.vers	8

//
// execution framework
//
__start:
	call	_main
	call	_exit
__stop:
	jmp	__stop

//
// Integer readInteger()
//
_readInteger:
	asf	0
	rdint
	popr
	rsf
	ret

//
// void writeInteger(Integer)
//
_writeInteger:
	asf	0
	pushl	-3
	wrint
	rsf
	ret

//
// Character readCharacter()
//
_readCharacter:
	asf	0
	rdchr
	popr
	rsf
	ret

//
// void writeCharacter(Character)
//
_writeCharacter:
	asf	0
	pushl	-3
	wrchr
	rsf
	ret

//
// Integer char2int(Character)
//
_char2int:
	asf	0
	pushl	-3
	popr
	rsf
	ret

//
// Character int2char(Integer)
//
_int2char:
	asf	0
	pushl	-3
	popr
	rsf
	ret

//
// void exit()
//
_exit:
	asf	0
	halt
	rsf
	ret

//
// void writeString(String)
//
_writeString:
	asf	1
	pushc	0
	popl	0
	jmp	_writeString_L2
_writeString_L1:
	pushl	-3
	pushl	0
	getfa
	call	_writeCharacter
	drop	1
	pushl	0
	pushc	1
	add
	popl	0
_writeString_L2:
	pushl	0
	pushl	-3
	getsz
	lt
	brt	_writeString_L1
	rsf
	ret

//
// void main()
//
_main:
	asf	2
	pushc	102
	popl	0
	pushc	2000
	popl	1
	pushc	9
	pushl	1
	add
	pushl	1
	mul
	pushl	0
	add
	popl	0
	pushc	9
	call	_fib
	drop	1
	pushr
	pushc	100
	call	_fib
	drop	1
	pushr
	add
	popl	1
	pushl	1
	call	_writeInteger
	drop	1
__0:
	rsf
	ret

//
// Integer fib(Integer)
//
_fib:
	asf	0
	pushl	-3
	pushc	1
	eq
	brf	__2
	pushl	-3
	popr
	jmp	__1
__2:
	pushl	-3
	pushc	0
	eq
	brf	__3
	pushc	0
	popr
	jmp	__1
__3:
	pushl	-3
	pushc	1
	sub
	call	_fib
	drop	1
	pushr
	pushl	-3
	pushc	2
	sub
	call	_fib
	drop	1
	pushr
	add
	popr
	jmp	__1
__1:
	rsf
	ret
