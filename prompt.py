from .user_interface import message
def counter(token):
    print("counter's", token)
    count = 0
    with open('corpus.txt', 'r') as f:
        data = f.read()
        data = data.split()
    for el in data:
        if el == token:
            count+=1
    return print(count)

def report_count(token):
    print(token)
    message(token)