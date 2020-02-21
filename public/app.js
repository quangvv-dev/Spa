function init() {
    if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this

    var $ = go.GraphObject.make;  // for conciseness in defining templates

    myDiagram = $(go.Diagram, "myDiagramDiv",  // create a Diagram for the DIV HTML element
      {
        "undoManager.isEnabled": true  // enable undo & redo
      });

    
    // This is the actual HTML context menu:
    var cxElement = document.getElementById("contextMenu");

    var myContextMenu = $(go.HTMLInfo, {
        show: showContextMenu,
        hide: hideContextMenu
    });

    // define a simple Node template
    myDiagram.nodeTemplate =
      $(go.Node, "Auto",  // the Shape will go around the TextBlock
        { contextMenu: myContextMenu },
        $(go.Shape, "RoundedRectangle", { strokeWidth: 0, fill: "white" },
          // Shape.fill is bound to Node.data.color
          new go.Binding("fill", "color")),
        $(go.TextBlock,
          { margin: 16, font: "bold 14px sans-serif", stroke: '#fff' }, // Specify a margin to add some room around the text
          // TextBlock.text is bound to Node.data.title
          new go.Binding("text", "title")),
          new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify)
          
      );

    // but use the default Link template, by not setting Diagram.linkTemplate



    // We don't want the div acting as a context menu to have a (browser) context menu!
    cxElement.addEventListener("contextmenu", function(e) {
        e.preventDefault();
        return false;
      }, false);

      function hideCX() {
        if (myDiagram.currentTool instanceof go.ContextMenuTool) {
          myDiagram.currentTool.doCancel();
        }
      }
      function showContextMenu(obj, diagram, tool) {
        // Show only the relevant buttons given the current state.
        var cmd = diagram.commandHandler;
        var hasMenuItem = false;
        function maybeShowItem(elt, pred) {
          if (pred) {
            elt.style.display = "block";
            hasMenuItem = true;
          } else {
            elt.style.display = "none";
          }
        }
        let selnode = diagram.selection.first();
        let selectedNodeType = selnode ? selnode.data.type : false
        maybeShowItem(document.getElementById("new_actor"), diagram.nodes.count === 0);
        maybeShowItem(document.getElementById("new_event"), obj !== null && selectedNodeType == 'actor');
        maybeShowItem(document.getElementById("new_action"), obj !== null && selectedNodeType == 'event');
        maybeShowItem(document.getElementById("delete"),  obj !== null && cmd.canDeleteSelection());
        maybeShowItem(document.getElementById("configs"),  obj !== null && selectedNodeType == 'action');

        // Now show the whole context menu element
        if (hasMenuItem) {
          cxElement.classList.add("show-menu");
          // we don't bother overriding positionContextMenu, we just do it here:
          var mousePt = diagram.lastInput.viewPoint;
          cxElement.style.left = mousePt.x + 5 + "px";
          cxElement.style.top = mousePt.y + "px";
        }

        // Optional: Use a `window` click listener with event capture to
        //           remove the context menu if the user clicks elsewhere on the page
        window.addEventListener("click", hideCX, true);
      }

      function hideContextMenu() {
        cxElement.classList.remove("show-menu");
        // Optional: Use a `window` click listener with event capture to
        //           remove the context menu if the user clicks elsewhere on the page
        window.removeEventListener("click", hideCX, true);
      }

    // USING FOR ADD NEW CUSTOMER
    myDiagram.contextMenu = myContextMenu;

    // create the model data that will be represented by Nodes and Links
    
    nodeDataArray = existingDiagram != '' && existingDiagram ? existingDiagram.nodeDataArray : []
    linkDataArray = existingDiagram != '' && existingDiagram ? existingDiagram.linkDataArray : []
    console.log(nodeDataArray)
    console.log(linkDataArray)
    myDiagram.model = new go.GraphLinksModel(
        nodeDataArray,linkDataArray);
}
function cxcommand(event, val) {
    if (val === undefined) val = event.currentTarget.id;
    var diagram = myDiagram;
    switch (val) {
        case "delete": {
            diagram.selection.first().findTreeParts().each((b) => {
                diagram.remove(b)
            })
            break;
        }
        case "configs": {
            let data = diagram.selection.first().data
            appendDataToModal('modal-action-email',data.configs)
            MicroModal.show('modal-action-email');
            // var jsonData = diagram.model.toJson();
            break;
        }
        case "new": {
            var id = event.target.getAttribute('data-id');
            if(id !== null){
                appliedModel = model.find(x => x.key == id )
                if(appliedModel){
                    let hasNode = diagram.findPartForData(appliedModel) !== null ? true : false
                    if(hasNode){
                        appliedModel = ({key,title,color,type} = appliedModel, {key,title,color,type})
                        appliedModel.key = new Date().getUTCMilliseconds()
                    }
                    addNewModel(diagram, appliedModel);
                }
            }
            
            break;
        }
    }
    diagram.currentTool.stopTool();
}

// A custom command, for changing the color of the selected node(s).
function changeColor(diagram, color) {
    // Always make changes in a transaction, except when initializing the diagram.
    diagram.startTransaction("change color");
    diagram.selection.each(function (node) {
        if (node instanceof go.Node) {  // ignore any selected Links and simple Parts
            // Examine and modify the data, not the Node directly.
            var data = node.data;
            // Call setDataProperty to support undo/redo as well as
            // automatically evaluating any relevant bindings.
            diagram.model.setDataProperty(data, "color", color);
        }
    });
    diagram.commitTransaction("change color");
}
function addNewModel(diagram, input) {
    // Always make changes in a transaction, except when initializing the diagram.
    var selnode = diagram.selection.first();
    diagram.commit(function(d) {
        var data = input;
        let downPoint = d.toolManager.contextMenuTool.mouseDownPoint
        // set location to saved mouseDownPoint in ContextMenuTool
        
        if(diagram.nodes.count >= 1){
            downPoint.x += 200 
        }
        data.loc = downPoint.x+' '+downPoint.y;
        d.model.addNodeData(data);
        part = d.findPartForData(data);  // must be same data reference, not a new {}
        part.location = downPoint

        
        
        
        
        
        
        if(selnode !== null){
            // and then add a link data connecting the original node with the new one
            var newlink = { from: selnode.data.key, to: data.key };
            // add the new link to the model
            d.model.addLinkData(newlink);
        }
    }, 'new node');
}
init()


MicroModal.init();

$('body').on('change','.condition-activator',(e) => {
    let a = $(e.target).val()
    let form = $(e.target).closest('form')
    $(form).find('.conditional-input').hide()
    $(form).find('.conditional-input.'+a).show()
})
$('body').on('click','.modal__btn-primary',(e) => {
    e.preventDefault();
    let a = $('.modal.is-open form').serializeArray()
    let diagram = myDiagram;
    let data = diagram.selection.first().data
    data.configs = a
    MicroModal.close();
})
appendDataToModal = (id_dom,configs) =>{
    let form = $('#'+id_dom).find('form')
    if(typeof configs !== 'undefined'){
        configs.forEach(element => {
            let ele = form.find('[name="'+element.name+'"]')
            if(ele.attr('type') == 'radio' || ele.attr('type') == 'checkbox'){
                form.find('[name="'+element.name+'"][value="'+element.value+'"]').prop('checked',true).trigger('change')

            }else{
                ele.val(element.value)
            }
        });
    }else{
        $(form).trigger('reset');
    }
}
$('body').on('click','#save',function()  {
    let diagram = myDiagram;
    var jsonData = diagram.model.toJson();
    $('[name="configs"]').val(JSON.stringify(jsonData))
    $('#rule_form').submit();
})

$(document).ready(function () {
    $('.datetimepicker').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        locale: {
            format: 'YYYY/MM/DD hh:mm'
        }
    });
})
