import xml.etree.ElementTree as ET
from math import sqrt

#combine aliases to a uniform name
def filter(item, tag, aliases):
	for alias in aliases:
		if tag in alias and item in alias:
			##print item, "--", alias[1]
			return alias[1]
	return item

#calculate distance between documents
def dist(row1, row2):
	d = 0
	for i in range(1, len(row1)):
		d += (row1[i] - row2[i]) * (row1[i] - row2[i])
	return sqrt(d)

#build doc-item matrix
def doc_item():
	doc_item = []
	for doc in root.iter('document'):
		docid = doc.find("docID")
		row = [docid.text]
		rowsum = 0
		for i in items:
			tmp = 0
			for child in doc:
				if child.text == i:
					tmp = 1
					rowsum += 1
			row.append(tmp)

		##print len(doc), "==", rowsum
		doc_item.append(row)
	##print doc_item
	doc_item.sort()
	return doc_item
##print "===\n\n", doc_item

#find co-occurance of items
def cooccur(item1, item2):
	cooccurance = 0
	for doc in root.iter('document'):
		childtexts = []
		for child in doc:
			item = child.text
			if item != None and child.tag != 'docID' and child.tag != 'docText':
				childtexts.append(item)
		if item1 in childtexts and item2 in childtexts:
			#print item1, "& ", item2, " cooccur in ", doc[0].text
			cooccurance += 1
	return cooccurance

#build item-item matrix
def item_item():
	item_item = []
	for pri_item in items:
		cooccurance = 0
		row = []
		#print pri_item
		for itr_item in items:
			#print itr_item
			cooccurance = cooccur(pri_item, itr_item)
			row.append(cooccurance)
			#print cooccurance
		item_item.append(row)
	return item_item

#calculate distance matrix
def doc_dist():
	doc_dist = []
	for row in doc_item:
		r = []
		for drow in doc_item:
			r.append(dist(row, drow))

		doc_dist.append(r)
	return doc_dist
##print doc_dist

tree = ET.parse('crescent.jig')
root = tree.getroot()

#build aliases dictionary
aliasedType = []
aliases = []
for name in root.iter('alias'):
	pid = []
	oid = []

	alias = [name[0][0].tag,name[0][0].text]

	#check if primary id and other id are of the same type
	for n in name:
		if "primary" in n.tag:
			pid.append(n)
		if "other" in n.tag:
			oid.append(n)
			alias.append(n[0].text)
	##print "pid is ", pid, "oid is ", oid
	aliases.append(alias)

	for o in oid:
		for p in pid:
			if (o == p):
				print "xml file error: id of different type ===> index: ", oid.index(o)
				break
			#extract the types that have aliases
			elif p[0].tag not in aliasedType:
				##print p[0].tag
				aliasedType.append(name[0][0].tag);

##print aliasedType, aliases

#doc_item = doc_item()

#find items
items = []
for doc in root.iter('document'):
	for child in doc:
		item = child.text
		if item not in items and item != None and child.tag != 'docID' and child.tag != 'docText':
			if child.tag in aliasedType:
				item = filter(item, child.tag, aliases)
			items.append(item)
items.sort()

item_item = []
for pri_item in items:
	cooccurance = 0
	row = []
	#print pri_item
	for itr_item in items:
		#print itr_item
		cooccurance = cooccur(pri_item, itr_item)
		row.append(cooccurance)
		#print cooccurance
	item_item.append(row)
print item_item

