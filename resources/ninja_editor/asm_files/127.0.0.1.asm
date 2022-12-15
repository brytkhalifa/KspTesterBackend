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
	asf	10
	call	_readInteger
	pushr
	popl	5
	call	_readInteger
	pushr
	popl	6
	call	_readInteger
	pushr
	popl	7
	call	_readInteger
	pushr
	popl	8
	call	_readInteger
	pushr
	popl	9
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	24
	newa
	dup
	pushc	0
	pushc	95
	putfa
	dup
	pushc	1
	pushc	66
	putfa
	dup
	pushc	2
	pushc	73
	putfa
	dup
	pushc	3
	pushc	78
	putfa
	dup
	pushc	4
	pushc	65
	putfa
	dup
	pushc	5
	pushc	82
	putfa
	dup
	pushc	6
	pushc	89
	putfa
	dup
	pushc	7
	pushc	95
	putfa
	dup
	pushc	8
	pushc	71
	putfa
	dup
	pushc	9
	pushc	69
	putfa
	dup
	pushc	10
	pushc	78
	putfa
	dup
	pushc	11
	pushc	69
	putfa
	dup
	pushc	12
	pushc	82
	putfa
	dup
	pushc	13
	pushc	65
	putfa
	dup
	pushc	14
	pushc	84
	putfa
	dup
	pushc	15
	pushc	79
	putfa
	dup
	pushc	16
	pushc	82
	putfa
	dup
	pushc	17
	pushc	95
	putfa
	dup
	pushc	18
	pushc	32
	putfa
	dup
	pushc	19
	pushc	110
	putfa
	dup
	pushc	20
	pushc	32
	putfa
	dup
	pushc	21
	pushc	58
	putfa
	dup
	pushc	22
	pushc	61
	putfa
	dup
	pushc	23
	pushc	32
	putfa
	call	_writeString
	drop	1
	pushl	5
	call	_writeInteger
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	29
	newa
	dup
	pushc	0
	pushc	45
	putfa
	dup
	pushc	1
	pushc	45
	putfa
	dup
	pushc	2
	pushc	45
	putfa
	dup
	pushc	3
	pushc	45
	putfa
	dup
	pushc	4
	pushc	45
	putfa
	dup
	pushc	5
	pushc	45
	putfa
	dup
	pushc	6
	pushc	45
	putfa
	dup
	pushc	7
	pushc	45
	putfa
	dup
	pushc	8
	pushc	45
	putfa
	dup
	pushc	9
	pushc	45
	putfa
	dup
	pushc	10
	pushc	45
	putfa
	dup
	pushc	11
	pushc	45
	putfa
	dup
	pushc	12
	pushc	45
	putfa
	dup
	pushc	13
	pushc	45
	putfa
	dup
	pushc	14
	pushc	45
	putfa
	dup
	pushc	15
	pushc	45
	putfa
	dup
	pushc	16
	pushc	45
	putfa
	dup
	pushc	17
	pushc	45
	putfa
	dup
	pushc	18
	pushc	45
	putfa
	dup
	pushc	19
	pushc	45
	putfa
	dup
	pushc	20
	pushc	45
	putfa
	dup
	pushc	21
	pushc	45
	putfa
	dup
	pushc	22
	pushc	45
	putfa
	dup
	pushc	23
	pushc	45
	putfa
	dup
	pushc	24
	pushc	45
	putfa
	dup
	pushc	25
	pushc	45
	putfa
	dup
	pushc	26
	pushc	45
	putfa
	dup
	pushc	27
	pushc	45
	putfa
	dup
	pushc	28
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushl	5
	call	_binGen
	drop	1
	pushc	58
	newa
	dup
	pushc	0
	pushc	10
	putfa
	dup
	pushc	1
	pushc	42
	putfa
	dup
	pushc	2
	pushc	42
	putfa
	dup
	pushc	3
	pushc	42
	putfa
	dup
	pushc	4
	pushc	42
	putfa
	dup
	pushc	5
	pushc	42
	putfa
	dup
	pushc	6
	pushc	42
	putfa
	dup
	pushc	7
	pushc	42
	putfa
	dup
	pushc	8
	pushc	42
	putfa
	dup
	pushc	9
	pushc	42
	putfa
	dup
	pushc	10
	pushc	42
	putfa
	dup
	pushc	11
	pushc	42
	putfa
	dup
	pushc	12
	pushc	42
	putfa
	dup
	pushc	13
	pushc	42
	putfa
	dup
	pushc	14
	pushc	42
	putfa
	dup
	pushc	15
	pushc	42
	putfa
	dup
	pushc	16
	pushc	42
	putfa
	dup
	pushc	17
	pushc	42
	putfa
	dup
	pushc	18
	pushc	42
	putfa
	dup
	pushc	19
	pushc	42
	putfa
	dup
	pushc	20
	pushc	42
	putfa
	dup
	pushc	21
	pushc	42
	putfa
	dup
	pushc	22
	pushc	42
	putfa
	dup
	pushc	23
	pushc	42
	putfa
	dup
	pushc	24
	pushc	42
	putfa
	dup
	pushc	25
	pushc	42
	putfa
	dup
	pushc	26
	pushc	42
	putfa
	dup
	pushc	27
	pushc	42
	putfa
	dup
	pushc	28
	pushc	42
	putfa
	dup
	pushc	29
	pushc	42
	putfa
	dup
	pushc	30
	pushc	42
	putfa
	dup
	pushc	31
	pushc	42
	putfa
	dup
	pushc	32
	pushc	42
	putfa
	dup
	pushc	33
	pushc	42
	putfa
	dup
	pushc	34
	pushc	42
	putfa
	dup
	pushc	35
	pushc	42
	putfa
	dup
	pushc	36
	pushc	42
	putfa
	dup
	pushc	37
	pushc	42
	putfa
	dup
	pushc	38
	pushc	42
	putfa
	dup
	pushc	39
	pushc	42
	putfa
	dup
	pushc	40
	pushc	42
	putfa
	dup
	pushc	41
	pushc	42
	putfa
	dup
	pushc	42
	pushc	42
	putfa
	dup
	pushc	43
	pushc	42
	putfa
	dup
	pushc	44
	pushc	42
	putfa
	dup
	pushc	45
	pushc	42
	putfa
	dup
	pushc	46
	pushc	42
	putfa
	dup
	pushc	47
	pushc	42
	putfa
	dup
	pushc	48
	pushc	42
	putfa
	dup
	pushc	49
	pushc	42
	putfa
	dup
	pushc	50
	pushc	42
	putfa
	dup
	pushc	51
	pushc	42
	putfa
	dup
	pushc	52
	pushc	42
	putfa
	dup
	pushc	53
	pushc	42
	putfa
	dup
	pushc	54
	pushc	42
	putfa
	dup
	pushc	55
	pushc	42
	putfa
	dup
	pushc	56
	pushc	42
	putfa
	dup
	pushc	57
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushc	24
	newa
	dup
	pushc	0
	pushc	95
	putfa
	dup
	pushc	1
	pushc	66
	putfa
	dup
	pushc	2
	pushc	73
	putfa
	dup
	pushc	3
	pushc	78
	putfa
	dup
	pushc	4
	pushc	65
	putfa
	dup
	pushc	5
	pushc	82
	putfa
	dup
	pushc	6
	pushc	89
	putfa
	dup
	pushc	7
	pushc	95
	putfa
	dup
	pushc	8
	pushc	71
	putfa
	dup
	pushc	9
	pushc	69
	putfa
	dup
	pushc	10
	pushc	78
	putfa
	dup
	pushc	11
	pushc	69
	putfa
	dup
	pushc	12
	pushc	82
	putfa
	dup
	pushc	13
	pushc	65
	putfa
	dup
	pushc	14
	pushc	84
	putfa
	dup
	pushc	15
	pushc	79
	putfa
	dup
	pushc	16
	pushc	82
	putfa
	dup
	pushc	17
	pushc	95
	putfa
	dup
	pushc	18
	pushc	32
	putfa
	dup
	pushc	19
	pushc	110
	putfa
	dup
	pushc	20
	pushc	32
	putfa
	dup
	pushc	21
	pushc	58
	putfa
	dup
	pushc	22
	pushc	61
	putfa
	dup
	pushc	23
	pushc	32
	putfa
	call	_writeString
	drop	1
	pushl	6
	call	_writeInteger
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	29
	newa
	dup
	pushc	0
	pushc	45
	putfa
	dup
	pushc	1
	pushc	45
	putfa
	dup
	pushc	2
	pushc	45
	putfa
	dup
	pushc	3
	pushc	45
	putfa
	dup
	pushc	4
	pushc	45
	putfa
	dup
	pushc	5
	pushc	45
	putfa
	dup
	pushc	6
	pushc	45
	putfa
	dup
	pushc	7
	pushc	45
	putfa
	dup
	pushc	8
	pushc	45
	putfa
	dup
	pushc	9
	pushc	45
	putfa
	dup
	pushc	10
	pushc	45
	putfa
	dup
	pushc	11
	pushc	45
	putfa
	dup
	pushc	12
	pushc	45
	putfa
	dup
	pushc	13
	pushc	45
	putfa
	dup
	pushc	14
	pushc	45
	putfa
	dup
	pushc	15
	pushc	45
	putfa
	dup
	pushc	16
	pushc	45
	putfa
	dup
	pushc	17
	pushc	45
	putfa
	dup
	pushc	18
	pushc	45
	putfa
	dup
	pushc	19
	pushc	45
	putfa
	dup
	pushc	20
	pushc	45
	putfa
	dup
	pushc	21
	pushc	45
	putfa
	dup
	pushc	22
	pushc	45
	putfa
	dup
	pushc	23
	pushc	45
	putfa
	dup
	pushc	24
	pushc	45
	putfa
	dup
	pushc	25
	pushc	45
	putfa
	dup
	pushc	26
	pushc	45
	putfa
	dup
	pushc	27
	pushc	45
	putfa
	dup
	pushc	28
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushl	6
	call	_binGen
	drop	1
	pushc	58
	newa
	dup
	pushc	0
	pushc	10
	putfa
	dup
	pushc	1
	pushc	42
	putfa
	dup
	pushc	2
	pushc	42
	putfa
	dup
	pushc	3
	pushc	42
	putfa
	dup
	pushc	4
	pushc	42
	putfa
	dup
	pushc	5
	pushc	42
	putfa
	dup
	pushc	6
	pushc	42
	putfa
	dup
	pushc	7
	pushc	42
	putfa
	dup
	pushc	8
	pushc	42
	putfa
	dup
	pushc	9
	pushc	42
	putfa
	dup
	pushc	10
	pushc	42
	putfa
	dup
	pushc	11
	pushc	42
	putfa
	dup
	pushc	12
	pushc	42
	putfa
	dup
	pushc	13
	pushc	42
	putfa
	dup
	pushc	14
	pushc	42
	putfa
	dup
	pushc	15
	pushc	42
	putfa
	dup
	pushc	16
	pushc	42
	putfa
	dup
	pushc	17
	pushc	42
	putfa
	dup
	pushc	18
	pushc	42
	putfa
	dup
	pushc	19
	pushc	42
	putfa
	dup
	pushc	20
	pushc	42
	putfa
	dup
	pushc	21
	pushc	42
	putfa
	dup
	pushc	22
	pushc	42
	putfa
	dup
	pushc	23
	pushc	42
	putfa
	dup
	pushc	24
	pushc	42
	putfa
	dup
	pushc	25
	pushc	42
	putfa
	dup
	pushc	26
	pushc	42
	putfa
	dup
	pushc	27
	pushc	42
	putfa
	dup
	pushc	28
	pushc	42
	putfa
	dup
	pushc	29
	pushc	42
	putfa
	dup
	pushc	30
	pushc	42
	putfa
	dup
	pushc	31
	pushc	42
	putfa
	dup
	pushc	32
	pushc	42
	putfa
	dup
	pushc	33
	pushc	42
	putfa
	dup
	pushc	34
	pushc	42
	putfa
	dup
	pushc	35
	pushc	42
	putfa
	dup
	pushc	36
	pushc	42
	putfa
	dup
	pushc	37
	pushc	42
	putfa
	dup
	pushc	38
	pushc	42
	putfa
	dup
	pushc	39
	pushc	42
	putfa
	dup
	pushc	40
	pushc	42
	putfa
	dup
	pushc	41
	pushc	42
	putfa
	dup
	pushc	42
	pushc	42
	putfa
	dup
	pushc	43
	pushc	42
	putfa
	dup
	pushc	44
	pushc	42
	putfa
	dup
	pushc	45
	pushc	42
	putfa
	dup
	pushc	46
	pushc	42
	putfa
	dup
	pushc	47
	pushc	42
	putfa
	dup
	pushc	48
	pushc	42
	putfa
	dup
	pushc	49
	pushc	42
	putfa
	dup
	pushc	50
	pushc	42
	putfa
	dup
	pushc	51
	pushc	42
	putfa
	dup
	pushc	52
	pushc	42
	putfa
	dup
	pushc	53
	pushc	42
	putfa
	dup
	pushc	54
	pushc	42
	putfa
	dup
	pushc	55
	pushc	42
	putfa
	dup
	pushc	56
	pushc	42
	putfa
	dup
	pushc	57
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushc	24
	newa
	dup
	pushc	0
	pushc	95
	putfa
	dup
	pushc	1
	pushc	66
	putfa
	dup
	pushc	2
	pushc	73
	putfa
	dup
	pushc	3
	pushc	78
	putfa
	dup
	pushc	4
	pushc	65
	putfa
	dup
	pushc	5
	pushc	82
	putfa
	dup
	pushc	6
	pushc	89
	putfa
	dup
	pushc	7
	pushc	95
	putfa
	dup
	pushc	8
	pushc	71
	putfa
	dup
	pushc	9
	pushc	69
	putfa
	dup
	pushc	10
	pushc	78
	putfa
	dup
	pushc	11
	pushc	69
	putfa
	dup
	pushc	12
	pushc	82
	putfa
	dup
	pushc	13
	pushc	65
	putfa
	dup
	pushc	14
	pushc	84
	putfa
	dup
	pushc	15
	pushc	79
	putfa
	dup
	pushc	16
	pushc	82
	putfa
	dup
	pushc	17
	pushc	95
	putfa
	dup
	pushc	18
	pushc	32
	putfa
	dup
	pushc	19
	pushc	110
	putfa
	dup
	pushc	20
	pushc	32
	putfa
	dup
	pushc	21
	pushc	58
	putfa
	dup
	pushc	22
	pushc	61
	putfa
	dup
	pushc	23
	pushc	32
	putfa
	call	_writeString
	drop	1
	pushl	7
	call	_writeInteger
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	29
	newa
	dup
	pushc	0
	pushc	45
	putfa
	dup
	pushc	1
	pushc	45
	putfa
	dup
	pushc	2
	pushc	45
	putfa
	dup
	pushc	3
	pushc	45
	putfa
	dup
	pushc	4
	pushc	45
	putfa
	dup
	pushc	5
	pushc	45
	putfa
	dup
	pushc	6
	pushc	45
	putfa
	dup
	pushc	7
	pushc	45
	putfa
	dup
	pushc	8
	pushc	45
	putfa
	dup
	pushc	9
	pushc	45
	putfa
	dup
	pushc	10
	pushc	45
	putfa
	dup
	pushc	11
	pushc	45
	putfa
	dup
	pushc	12
	pushc	45
	putfa
	dup
	pushc	13
	pushc	45
	putfa
	dup
	pushc	14
	pushc	45
	putfa
	dup
	pushc	15
	pushc	45
	putfa
	dup
	pushc	16
	pushc	45
	putfa
	dup
	pushc	17
	pushc	45
	putfa
	dup
	pushc	18
	pushc	45
	putfa
	dup
	pushc	19
	pushc	45
	putfa
	dup
	pushc	20
	pushc	45
	putfa
	dup
	pushc	21
	pushc	45
	putfa
	dup
	pushc	22
	pushc	45
	putfa
	dup
	pushc	23
	pushc	45
	putfa
	dup
	pushc	24
	pushc	45
	putfa
	dup
	pushc	25
	pushc	45
	putfa
	dup
	pushc	26
	pushc	45
	putfa
	dup
	pushc	27
	pushc	45
	putfa
	dup
	pushc	28
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushl	7
	call	_binGen
	drop	1
	pushc	58
	newa
	dup
	pushc	0
	pushc	10
	putfa
	dup
	pushc	1
	pushc	42
	putfa
	dup
	pushc	2
	pushc	42
	putfa
	dup
	pushc	3
	pushc	42
	putfa
	dup
	pushc	4
	pushc	42
	putfa
	dup
	pushc	5
	pushc	42
	putfa
	dup
	pushc	6
	pushc	42
	putfa
	dup
	pushc	7
	pushc	42
	putfa
	dup
	pushc	8
	pushc	42
	putfa
	dup
	pushc	9
	pushc	42
	putfa
	dup
	pushc	10
	pushc	42
	putfa
	dup
	pushc	11
	pushc	42
	putfa
	dup
	pushc	12
	pushc	42
	putfa
	dup
	pushc	13
	pushc	42
	putfa
	dup
	pushc	14
	pushc	42
	putfa
	dup
	pushc	15
	pushc	42
	putfa
	dup
	pushc	16
	pushc	42
	putfa
	dup
	pushc	17
	pushc	42
	putfa
	dup
	pushc	18
	pushc	42
	putfa
	dup
	pushc	19
	pushc	42
	putfa
	dup
	pushc	20
	pushc	42
	putfa
	dup
	pushc	21
	pushc	42
	putfa
	dup
	pushc	22
	pushc	42
	putfa
	dup
	pushc	23
	pushc	42
	putfa
	dup
	pushc	24
	pushc	42
	putfa
	dup
	pushc	25
	pushc	42
	putfa
	dup
	pushc	26
	pushc	42
	putfa
	dup
	pushc	27
	pushc	42
	putfa
	dup
	pushc	28
	pushc	42
	putfa
	dup
	pushc	29
	pushc	42
	putfa
	dup
	pushc	30
	pushc	42
	putfa
	dup
	pushc	31
	pushc	42
	putfa
	dup
	pushc	32
	pushc	42
	putfa
	dup
	pushc	33
	pushc	42
	putfa
	dup
	pushc	34
	pushc	42
	putfa
	dup
	pushc	35
	pushc	42
	putfa
	dup
	pushc	36
	pushc	42
	putfa
	dup
	pushc	37
	pushc	42
	putfa
	dup
	pushc	38
	pushc	42
	putfa
	dup
	pushc	39
	pushc	42
	putfa
	dup
	pushc	40
	pushc	42
	putfa
	dup
	pushc	41
	pushc	42
	putfa
	dup
	pushc	42
	pushc	42
	putfa
	dup
	pushc	43
	pushc	42
	putfa
	dup
	pushc	44
	pushc	42
	putfa
	dup
	pushc	45
	pushc	42
	putfa
	dup
	pushc	46
	pushc	42
	putfa
	dup
	pushc	47
	pushc	42
	putfa
	dup
	pushc	48
	pushc	42
	putfa
	dup
	pushc	49
	pushc	42
	putfa
	dup
	pushc	50
	pushc	42
	putfa
	dup
	pushc	51
	pushc	42
	putfa
	dup
	pushc	52
	pushc	42
	putfa
	dup
	pushc	53
	pushc	42
	putfa
	dup
	pushc	54
	pushc	42
	putfa
	dup
	pushc	55
	pushc	42
	putfa
	dup
	pushc	56
	pushc	42
	putfa
	dup
	pushc	57
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushc	24
	newa
	dup
	pushc	0
	pushc	95
	putfa
	dup
	pushc	1
	pushc	66
	putfa
	dup
	pushc	2
	pushc	73
	putfa
	dup
	pushc	3
	pushc	78
	putfa
	dup
	pushc	4
	pushc	65
	putfa
	dup
	pushc	5
	pushc	82
	putfa
	dup
	pushc	6
	pushc	89
	putfa
	dup
	pushc	7
	pushc	95
	putfa
	dup
	pushc	8
	pushc	71
	putfa
	dup
	pushc	9
	pushc	69
	putfa
	dup
	pushc	10
	pushc	78
	putfa
	dup
	pushc	11
	pushc	69
	putfa
	dup
	pushc	12
	pushc	82
	putfa
	dup
	pushc	13
	pushc	65
	putfa
	dup
	pushc	14
	pushc	84
	putfa
	dup
	pushc	15
	pushc	79
	putfa
	dup
	pushc	16
	pushc	82
	putfa
	dup
	pushc	17
	pushc	95
	putfa
	dup
	pushc	18
	pushc	32
	putfa
	dup
	pushc	19
	pushc	110
	putfa
	dup
	pushc	20
	pushc	32
	putfa
	dup
	pushc	21
	pushc	58
	putfa
	dup
	pushc	22
	pushc	61
	putfa
	dup
	pushc	23
	pushc	32
	putfa
	call	_writeString
	drop	1
	pushl	8
	call	_writeInteger
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	29
	newa
	dup
	pushc	0
	pushc	45
	putfa
	dup
	pushc	1
	pushc	45
	putfa
	dup
	pushc	2
	pushc	45
	putfa
	dup
	pushc	3
	pushc	45
	putfa
	dup
	pushc	4
	pushc	45
	putfa
	dup
	pushc	5
	pushc	45
	putfa
	dup
	pushc	6
	pushc	45
	putfa
	dup
	pushc	7
	pushc	45
	putfa
	dup
	pushc	8
	pushc	45
	putfa
	dup
	pushc	9
	pushc	45
	putfa
	dup
	pushc	10
	pushc	45
	putfa
	dup
	pushc	11
	pushc	45
	putfa
	dup
	pushc	12
	pushc	45
	putfa
	dup
	pushc	13
	pushc	45
	putfa
	dup
	pushc	14
	pushc	45
	putfa
	dup
	pushc	15
	pushc	45
	putfa
	dup
	pushc	16
	pushc	45
	putfa
	dup
	pushc	17
	pushc	45
	putfa
	dup
	pushc	18
	pushc	45
	putfa
	dup
	pushc	19
	pushc	45
	putfa
	dup
	pushc	20
	pushc	45
	putfa
	dup
	pushc	21
	pushc	45
	putfa
	dup
	pushc	22
	pushc	45
	putfa
	dup
	pushc	23
	pushc	45
	putfa
	dup
	pushc	24
	pushc	45
	putfa
	dup
	pushc	25
	pushc	45
	putfa
	dup
	pushc	26
	pushc	45
	putfa
	dup
	pushc	27
	pushc	45
	putfa
	dup
	pushc	28
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushl	8
	call	_binGen
	drop	1
	pushc	58
	newa
	dup
	pushc	0
	pushc	10
	putfa
	dup
	pushc	1
	pushc	42
	putfa
	dup
	pushc	2
	pushc	42
	putfa
	dup
	pushc	3
	pushc	42
	putfa
	dup
	pushc	4
	pushc	42
	putfa
	dup
	pushc	5
	pushc	42
	putfa
	dup
	pushc	6
	pushc	42
	putfa
	dup
	pushc	7
	pushc	42
	putfa
	dup
	pushc	8
	pushc	42
	putfa
	dup
	pushc	9
	pushc	42
	putfa
	dup
	pushc	10
	pushc	42
	putfa
	dup
	pushc	11
	pushc	42
	putfa
	dup
	pushc	12
	pushc	42
	putfa
	dup
	pushc	13
	pushc	42
	putfa
	dup
	pushc	14
	pushc	42
	putfa
	dup
	pushc	15
	pushc	42
	putfa
	dup
	pushc	16
	pushc	42
	putfa
	dup
	pushc	17
	pushc	42
	putfa
	dup
	pushc	18
	pushc	42
	putfa
	dup
	pushc	19
	pushc	42
	putfa
	dup
	pushc	20
	pushc	42
	putfa
	dup
	pushc	21
	pushc	42
	putfa
	dup
	pushc	22
	pushc	42
	putfa
	dup
	pushc	23
	pushc	42
	putfa
	dup
	pushc	24
	pushc	42
	putfa
	dup
	pushc	25
	pushc	42
	putfa
	dup
	pushc	26
	pushc	42
	putfa
	dup
	pushc	27
	pushc	42
	putfa
	dup
	pushc	28
	pushc	42
	putfa
	dup
	pushc	29
	pushc	42
	putfa
	dup
	pushc	30
	pushc	42
	putfa
	dup
	pushc	31
	pushc	42
	putfa
	dup
	pushc	32
	pushc	42
	putfa
	dup
	pushc	33
	pushc	42
	putfa
	dup
	pushc	34
	pushc	42
	putfa
	dup
	pushc	35
	pushc	42
	putfa
	dup
	pushc	36
	pushc	42
	putfa
	dup
	pushc	37
	pushc	42
	putfa
	dup
	pushc	38
	pushc	42
	putfa
	dup
	pushc	39
	pushc	42
	putfa
	dup
	pushc	40
	pushc	42
	putfa
	dup
	pushc	41
	pushc	42
	putfa
	dup
	pushc	42
	pushc	42
	putfa
	dup
	pushc	43
	pushc	42
	putfa
	dup
	pushc	44
	pushc	42
	putfa
	dup
	pushc	45
	pushc	42
	putfa
	dup
	pushc	46
	pushc	42
	putfa
	dup
	pushc	47
	pushc	42
	putfa
	dup
	pushc	48
	pushc	42
	putfa
	dup
	pushc	49
	pushc	42
	putfa
	dup
	pushc	50
	pushc	42
	putfa
	dup
	pushc	51
	pushc	42
	putfa
	dup
	pushc	52
	pushc	42
	putfa
	dup
	pushc	53
	pushc	42
	putfa
	dup
	pushc	54
	pushc	42
	putfa
	dup
	pushc	55
	pushc	42
	putfa
	dup
	pushc	56
	pushc	42
	putfa
	dup
	pushc	57
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushc	24
	newa
	dup
	pushc	0
	pushc	95
	putfa
	dup
	pushc	1
	pushc	66
	putfa
	dup
	pushc	2
	pushc	73
	putfa
	dup
	pushc	3
	pushc	78
	putfa
	dup
	pushc	4
	pushc	65
	putfa
	dup
	pushc	5
	pushc	82
	putfa
	dup
	pushc	6
	pushc	89
	putfa
	dup
	pushc	7
	pushc	95
	putfa
	dup
	pushc	8
	pushc	71
	putfa
	dup
	pushc	9
	pushc	69
	putfa
	dup
	pushc	10
	pushc	78
	putfa
	dup
	pushc	11
	pushc	69
	putfa
	dup
	pushc	12
	pushc	82
	putfa
	dup
	pushc	13
	pushc	65
	putfa
	dup
	pushc	14
	pushc	84
	putfa
	dup
	pushc	15
	pushc	79
	putfa
	dup
	pushc	16
	pushc	82
	putfa
	dup
	pushc	17
	pushc	95
	putfa
	dup
	pushc	18
	pushc	32
	putfa
	dup
	pushc	19
	pushc	110
	putfa
	dup
	pushc	20
	pushc	32
	putfa
	dup
	pushc	21
	pushc	58
	putfa
	dup
	pushc	22
	pushc	61
	putfa
	dup
	pushc	23
	pushc	32
	putfa
	call	_writeString
	drop	1
	pushl	9
	call	_writeInteger
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	pushc	29
	newa
	dup
	pushc	0
	pushc	45
	putfa
	dup
	pushc	1
	pushc	45
	putfa
	dup
	pushc	2
	pushc	45
	putfa
	dup
	pushc	3
	pushc	45
	putfa
	dup
	pushc	4
	pushc	45
	putfa
	dup
	pushc	5
	pushc	45
	putfa
	dup
	pushc	6
	pushc	45
	putfa
	dup
	pushc	7
	pushc	45
	putfa
	dup
	pushc	8
	pushc	45
	putfa
	dup
	pushc	9
	pushc	45
	putfa
	dup
	pushc	10
	pushc	45
	putfa
	dup
	pushc	11
	pushc	45
	putfa
	dup
	pushc	12
	pushc	45
	putfa
	dup
	pushc	13
	pushc	45
	putfa
	dup
	pushc	14
	pushc	45
	putfa
	dup
	pushc	15
	pushc	45
	putfa
	dup
	pushc	16
	pushc	45
	putfa
	dup
	pushc	17
	pushc	45
	putfa
	dup
	pushc	18
	pushc	45
	putfa
	dup
	pushc	19
	pushc	45
	putfa
	dup
	pushc	20
	pushc	45
	putfa
	dup
	pushc	21
	pushc	45
	putfa
	dup
	pushc	22
	pushc	45
	putfa
	dup
	pushc	23
	pushc	45
	putfa
	dup
	pushc	24
	pushc	45
	putfa
	dup
	pushc	25
	pushc	45
	putfa
	dup
	pushc	26
	pushc	45
	putfa
	dup
	pushc	27
	pushc	45
	putfa
	dup
	pushc	28
	pushc	10
	putfa
	call	_writeString
	drop	1
	pushl	9
	call	_binGen
	drop	1
__0:
	rsf
	ret

//
// Integer power(Integer, Integer)
//
_power:
	asf	1
	pushl	-4
	popl	0
	pushl	-3
	pushc	0
	eq
	brf	__2
	pushc	1
	popr
	jmp	__1
__2:
	jmp	__4
__3:
	pushl	-4
	pushl	0
	mul
	popl	-4
	pushl	-3
	pushc	1
	sub
	popl	-3
__4:
	pushl	-3
	pushc	1
	gt
	brt	__3
__5:
	pushl	-4
	popr
	jmp	__1
__1:
	rsf
	ret

//
// record { Integer[] array; Integer capacity; Integer in; } newIntList()
//
_newIntList:
	asf	1
	new	3
	popl	0
	pushl	0
	pushc	0
	putf	2
	pushl	0
	pushc	1000
	newa
	putf	0
	pushl	0
	pushc	1000
	putf	1
	pushl	0
	popr
	jmp	__6
__6:
	rsf
	ret

//
// void add(record { Integer[] array; Integer capacity; Integer in; }, Integer)
//
_add:
	asf	1
	pushl	-4
	getf	2
	popl	0
	pushl	0
	pushl	-4
	getf	1
	eq
	brf	__8
	pushl	-4
	call	_increaseSize
	drop	1
	pushr
	popl	-4
__8:
	pushl	-4
	getf	0
	pushl	0
	pushl	-3
	putfa
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	add
	putf	2
__7:
	rsf
	ret

//
// Integer get(record { Integer[] array; Integer capacity; Integer in; }, Integer)
//
_get:
	asf	0
	pushl	-3
	pushl	-4
	getf	1
	eq
	brf	__10
	pushc	0
	pushc	1
	sub
	popr
	jmp	__9
__10:
	pushl	-3
	pushc	0
	lt
	brf	__11
	pushc	0
	pushc	1
	sub
	popr
	jmp	__9
__11:
	pushl	-4
	call	_isEmpty
	drop	1
	pushr
	brf	__12
	pushc	0
	pushc	1
	sub
	popr
	jmp	__9
__12:
	pushl	-4
	getf	0
	pushl	-3
	getfa
	popr
	jmp	__9
__9:
	rsf
	ret

//
// Integer getSize(record { Integer[] array; Integer capacity; Integer in; })
//
_getSize:
	asf	0
	pushl	-3
	getf	2
	popr
	jmp	__13
__13:
	rsf
	ret

//
// Boolean remove(record { Integer[] array; Integer capacity; Integer in; }, Integer)
//
_remove:
	asf	2
	pushl	-3
	pushl	-4
	getf	1
	eq
	brf	__15
	pushc	0
	popr
	jmp	__14
__15:
	pushl	-3
	pushc	0
	lt
	brf	__16
	pushc	0
	popr
	jmp	__14
__16:
	pushl	-3
	popl	0
	jmp	__18
__17:
	pushl	0
	pushc	1
	add
	popl	1
	pushl	-4
	getf	0
	pushl	0
	pushl	-4
	getf	0
	pushl	1
	getfa
	putfa
	pushl	0
	pushc	1
	add
	popl	0
__18:
	pushl	0
	pushl	-4
	getf	1
	lt
	brt	__17
__19:
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	sub
	putf	2
	pushc	1
	popr
	jmp	__14
__14:
	rsf
	ret

//
// record { Integer[] array; Integer capacity; Integer in; } increaseSize(record { Integer[] array; Integer capacity; Integer in; })
//
_increaseSize:
	asf	3
	pushl	-3
	getf	1
	pushl	-3
	getf	1
	mul
	popl	1
	pushl	1
	newa
	popl	0
	pushl	-3
	pushl	0
	putf	0
	pushl	-3
	pushl	1
	putf	1
	pushl	-3
	popr
	jmp	__20
__20:
	rsf
	ret

//
// Boolean isEmpty(record { Integer[] array; Integer capacity; Integer in; })
//
_isEmpty:
	asf	0
	pushl	-3
	getf	2
	pushc	0
	eq
	brf	__22
	pushc	1
	popr
	jmp	__21
__22:
	pushc	0
	popr
	jmp	__21
__21:
	rsf
	ret

//
// void iClear(record { Integer[] array; Integer capacity; Integer in; })
//
_iClear:
	asf	0
	call	_newIntList
	pushr
	popl	-3
__23:
	rsf
	ret

//
// record { CharList[] buffer; Integer capacity; Integer in; } newStringMaker()
//
_newStringMaker:
	asf	1
	new	3
	popl	0
	pushl	0
	pushc	0
	putf	2
	pushl	0
	pushc	1000
	newa
	putf	0
	pushl	0
	pushc	1000
	putf	1
	pushl	0
	popr
	jmp	__24
__24:
	rsf
	ret

//
// record { Character[] array; Integer capacity; Integer in; } sGet(record { CharList[] buffer; Integer capacity; Integer in; }, Integer)
//
_sGet:
	asf	0
	pushl	-3
	pushl	-4
	getf	1
	eq
	brf	__26
	call	_newCharList
	pushr
	popr
	jmp	__25
__26:
	pushl	-3
	pushc	0
	lt
	brf	__27
	call	_newCharList
	pushr
	popr
	jmp	__25
__27:
	pushl	-4
	call	_sIsEmpty
	drop	1
	pushr
	brf	__28
	call	_newCharList
	pushr
	popr
	jmp	__25
__28:
	pushl	-4
	getf	0
	pushl	-3
	getfa
	popr
	jmp	__25
__25:
	rsf
	ret

//
// void sAdd(record { CharList[] buffer; Integer capacity; Integer in; }, record { Character[] array; Integer capacity; Integer in; })
//
_sAdd:
	asf	2
	call	_newCharList
	pushr
	popl	0
	pushl	-4
	getf	2
	popl	1
	pushl	0
	pushl	-3
	getf	0
	putf	0
	pushl	0
	pushl	-3
	getf	2
	putf	2
	pushl	1
	pushl	-4
	getf	1
	eq
	brf	__30
	pushl	-4
	call	_sIncreaseSize
	drop	1
	pushr
	popl	-4
__30:
	pushl	-4
	getf	0
	pushl	1
	pushl	0
	putfa
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	add
	putf	2
__29:
	rsf
	ret

//
// Integer sGetSize(record { CharList[] buffer; Integer capacity; Integer in; })
//
_sGetSize:
	asf	0
	pushl	-3
	getf	2
	popr
	jmp	__31
__31:
	rsf
	ret

//
// Boolean sRemove(record { CharList[] buffer; Integer capacity; Integer in; }, Integer)
//
_sRemove:
	asf	2
	pushl	-3
	pushl	-4
	getf	1
	eq
	brf	__33
	pushc	0
	popr
	jmp	__32
__33:
	pushl	-3
	pushc	0
	lt
	brf	__34
	pushc	0
	popr
	jmp	__32
__34:
	pushl	-3
	popl	0
	jmp	__36
__35:
	pushl	0
	pushc	1
	add
	popl	1
	pushl	-4
	getf	0
	pushl	0
	pushl	-4
	getf	0
	pushl	1
	getfa
	putfa
	pushl	0
	pushc	1
	add
	popl	0
__36:
	pushl	0
	pushl	-4
	getf	1
	lt
	brt	__35
__37:
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	sub
	putf	2
	pushc	1
	popr
	jmp	__32
__32:
	rsf
	ret

//
// record { CharList[] buffer; Integer capacity; Integer in; } sIncreaseSize(record { CharList[] buffer; Integer capacity; Integer in; })
//
_sIncreaseSize:
	asf	3
	pushl	-3
	getf	1
	pushl	-3
	getf	1
	mul
	popl	1
	pushl	1
	newa
	popl	0
	pushl	-3
	pushl	0
	putf	0
	pushl	-3
	pushl	1
	putf	1
	pushl	-3
	popr
	jmp	__38
__38:
	rsf
	ret

//
// Boolean sIsEmpty(record { CharList[] buffer; Integer capacity; Integer in; })
//
_sIsEmpty:
	asf	0
	pushl	-3
	getf	2
	pushc	0
	eq
	brf	__40
	pushc	1
	popr
	jmp	__39
__40:
	pushc	0
	popr
	jmp	__39
__39:
	rsf
	ret

//
// void sClear(record { CharList[] buffer; Integer capacity; Integer in; })
//
_sClear:
	asf	0
	call	_newStringMaker
	pushr
	popl	-3
__41:
	rsf
	ret

//
// record { Character[] array; Integer capacity; Integer in; } newCharList()
//
_newCharList:
	asf	1
	new	3
	popl	0
	pushl	0
	pushc	0
	putf	2
	pushl	0
	pushc	1000
	newa
	putf	0
	pushl	0
	pushc	1000
	putf	1
	pushl	0
	popr
	jmp	__42
__42:
	rsf
	ret

//
// void cAdd(record { Character[] array; Integer capacity; Integer in; }, Character)
//
_cAdd:
	asf	1
	pushl	-4
	getf	2
	popl	0
	pushl	0
	pushl	-4
	getf	1
	eq
	brf	__44
	pushl	-4
	call	_cIncreaseSize
	drop	1
	pushr
	popl	-4
__44:
	pushl	-4
	getf	0
	pushl	0
	pushl	-3
	putfa
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	add
	putf	2
__43:
	rsf
	ret

//
// Character cGet(record { Character[] array; Integer capacity; Integer in; }, Integer)
//
_cGet:
	asf	0
	pushl	-3
	pushl	-4
	getf	1
	eq
	brf	__46
	pushc	36
	popr
	jmp	__45
__46:
	pushl	-3
	pushc	0
	lt
	brf	__47
	pushc	36
	popr
	jmp	__45
__47:
	pushl	-4
	call	_cIsEmpty
	drop	1
	pushr
	brf	__48
	pushc	36
	popr
	jmp	__45
__48:
	pushl	-4
	getf	0
	pushl	-3
	getfa
	popr
	jmp	__45
__45:
	rsf
	ret

//
// Integer cGetSize(record { Character[] array; Integer capacity; Integer in; })
//
_cGetSize:
	asf	0
	pushl	-3
	getf	2
	popr
	jmp	__49
__49:
	rsf
	ret

//
// void cPrint(record { Character[] array; Integer capacity; Integer in; })
//
_cPrint:
	asf	1
	pushc	0
	popl	0
	jmp	__52
__51:
	pushl	-3
	getf	0
	pushl	0
	getfa
	call	_writeCharacter
	drop	1
	pushl	0
	pushc	1
	add
	popl	0
__52:
	pushl	0
	pushl	-3
	getf	2
	lt
	brt	__51
__53:
__50:
	rsf
	ret

//
// Boolean cRemove(record { Character[] array; Integer capacity; Integer in; }, Integer)
//
_cRemove:
	asf	2
	pushl	-3
	pushl	-4
	getf	2
	gt
	brf	__55
	pushc	0
	popr
	jmp	__54
__55:
	pushl	-3
	pushc	0
	lt
	brf	__56
	pushc	0
	popr
	jmp	__54
__56:
	pushc	0
	popl	0
	jmp	__58
__57:
	pushl	0
	pushl	-3
	lt
	brf	__60
	pushl	-4
	getf	0
	pushl	0
	pushl	-4
	getf	0
	pushl	0
	getfa
	putfa
	jmp	__61
__60:
	pushl	-4
	getf	0
	pushl	0
	pushl	-4
	getf	0
	pushl	0
	pushc	1
	add
	getfa
	putfa
__61:
	pushl	0
	pushc	1
	add
	popl	0
__58:
	pushl	0
	pushl	-4
	getf	2
	pushc	1
	sub
	lt
	brt	__57
__59:
	pushl	-4
	pushl	-4
	getf	2
	pushc	1
	sub
	putf	2
	pushc	1
	popr
	jmp	__54
__54:
	rsf
	ret

//
// record { Character[] array; Integer capacity; Integer in; } cIncreaseSize(record { Character[] array; Integer capacity; Integer in; })
//
_cIncreaseSize:
	asf	3
	pushl	-3
	getf	1
	pushl	-3
	getf	1
	mul
	popl	1
	pushl	1
	newa
	popl	0
	pushl	-3
	pushl	0
	putf	0
	pushl	-3
	pushl	1
	putf	1
	pushl	-3
	popr
	jmp	__62
__62:
	rsf
	ret

//
// Boolean cIsEmpty(record { Character[] array; Integer capacity; Integer in; })
//
_cIsEmpty:
	asf	0
	pushl	-3
	getf	2
	pushc	0
	eq
	brf	__64
	pushc	1
	popr
	jmp	__63
__64:
	pushc	0
	popr
	jmp	__63
__63:
	rsf
	ret

//
// record { Character[] array; Integer capacity; Integer in; } cClear(record { Character[] array; Integer capacity; Integer in; })
//
_cClear:
	asf	0
	pushl	-3
	pushc	0
	putf	2
	pushl	-3
	popr
	jmp	__65
__65:
	rsf
	ret

//
// void binGen(Integer)
//
_binGen:
	asf	1
	call	_newCharList
	pushr
	popl	0
	pushl	-3
	pushl	0
	call	_binGenRec
	drop	2
__66:
	rsf
	ret

//
// void binGenRec(Integer, record { Character[] array; Integer capacity; Integer in; })
//
_binGenRec:
	asf	0
	pushl	-4
	pushc	0
	eq
	brf	__68
	pushl	-3
	call	_cPrint
	drop	1
	pushc	10
	call	_writeCharacter
	drop	1
	jmp	__69
__68:
	pushl	-3
	pushc	48
	call	_cAdd
	drop	2
	pushl	-4
	pushc	1
	sub
	pushl	-3
	call	_binGenRec
	drop	2
	pushl	-3
	pushl	-3
	getf	2
	pushc	1
	sub
	call	_cRemove
	drop	2
	pushl	-3
	pushc	49
	call	_cAdd
	drop	2
	pushl	-4
	pushc	1
	sub
	pushl	-3
	call	_binGenRec
	drop	2
	pushl	-3
	pushl	-3
	getf	2
	pushc	1
	sub
	call	_cRemove
	drop	2
__69:
__67:
	rsf
	ret
