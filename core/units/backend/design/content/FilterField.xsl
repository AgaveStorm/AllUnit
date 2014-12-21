<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="FilterField">
	<xsl:param name="type"/>
	<xsl:param name="name"/>
	<xsl:param name="list"/>
	<xsl:param name="value"/>
	<xsl:choose>

		<xsl:when test="$type = 'bool'">
                        <select name="{$name}">
                            <option value=''>--</option>
                            <option value='on'>
                                <xsl:if test="$value = 'on'">
                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                </xsl:if>
                                Yes
                            </option>
                            <option value='off'>
                                <xsl:if test="$value = 'off'">
                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                </xsl:if>
                                No
                            </option>
                        </select>
		</xsl:when>

		<xsl:when test="$type = 'date'">
			From <input type="text" name="{$name}[from]" value="{$value/from}" class="datepicker"/><br/>
			To <input type="text" name="{$name}[to]" value="{$value/to}" class="datepicker"/>
		</xsl:when>
		
		<xsl:when test="$type = 'cardno'">
			From <input type="text" name="{$name}[from]" value="{$value/from}" class="number"/><br/>
			To <input type="text" name="{$name}[to]" value="{$value/to}" class="number"/>
		</xsl:when>
                
                <xsl:when test="$type = 'multiid'">
                    <select name="{$name}[]" class="multiselect" multiple="yes">
                        <xsl:for-each select="../../child::node()[name()=$list]/item">
                            <xsl:variable name="id" select="id"/>
                                <option value="{id}">
                                    <xsl:if test="$value/item[.=$id]">
                                        <xsl:attribute name="selected">yes</xsl:attribute>
                                    </xsl:if>
                                    <xsl:value-of select="title"/>
                                </option>
                        </xsl:for-each>
                    </select>
                </xsl:when>
                
                <xsl:when test="$type = 'id'">
                    <select name="{$name}[]" class="multiselect" multiple="yes">
                        <xsl:for-each select="../../child::node()[name()=$list]/item">
                            <xsl:variable name="id" select="id"/>
                                <option value="{id}">
                                    <xsl:if test="$value/item[.=$id]">
                                        <xsl:attribute name="selected">yes</xsl:attribute>
                                    </xsl:if>
                                    <xsl:value-of select="title"/>
                                </option>
                        </xsl:for-each>
                    </select>
                </xsl:when>

		<xsl:when test="$type/item">
			<select name="{$name}" class="filterSelect">
			    <option value="">--</option>
			    <xsl:for-each select="$type/item">
				<option value="{position()}">
				    <xsl:if test="$value=position()">
					<xsl:attribute name="selected">yes</xsl:attribute>
				    </xsl:if>
				    <xsl:value-of select="."/>
				</option>
			    </xsl:for-each>
			</select>
		</xsl:when>
		<xsl:otherwise>
			<input type="text" name="{$name}" value="{$value}"/>
		</xsl:otherwise>
	    </xsl:choose>
    </xsl:template>
</xsl:stylesheet>
